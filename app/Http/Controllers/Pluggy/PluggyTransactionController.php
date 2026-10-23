<?php

namespace App\Http\Controllers\Pluggy;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PluggyTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\MonthlyBalanceService;
use App\Services\Pluggy\PluggyTransactionClassifier;
use Illuminate\Support\Facades\DB;

class PluggyTransactionController extends Controller
{
    public function show(Request $request, int $transaction): View
    {
        return view('pluggy.transactions.show', [
            'transaction' => $this->transactionForUser($request, $transaction),
        ]);
    }

    public function edit(Request $request, int $transaction): View
    {
        $transaction = $this->transactionForUser($request, $transaction);
        $categoryType = $transaction->classification === PluggyTransaction::CLASSIFICATION_INCOME
            ? 'income'
            : 'expense';

        return view('pluggy.transactions.edit', [
            'transaction' => $transaction,
            'categories' => Category::query()
                ->where('user_id', $request->user()->id)
                ->where('type', $categoryType)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, int $transaction): RedirectResponse
    {
        $transaction = $this->transactionForUser($request, $transaction);
        $categoryType = $transaction->classification === PluggyTransaction::CLASSIFICATION_INCOME
            ? 'income'
            : 'expense';

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:500'],
            'transaction_date' => ['required', 'date'],
            'category_id' => ['nullable', 'integer'],
            'payment_method' => ['sometimes', 'required', 'in:keep,auto,pix,card,debito,credito,dinheiro,other'],
            'restore_automatic' => ['sometimes', 'boolean'],
        ]);

        if ($validated['category_id'] !== null && ! Category::query()
            ->whereKey($validated['category_id'])
            ->where('user_id', $request->user()->id)
            ->where('type', $categoryType)
            ->exists()) {
            return back()->withErrors(['category_id' => 'Escolha uma categoria válida.'])->withInput();
        }

        $transaction = DB::transaction(function () use ($transaction, $validated, $request) {
        $transaction = PluggyTransaction::query()->where('user_id', $request->user()->id)
            ->whereNull('removed_at')->whereNull('deleted_by_user_at')->lockForUpdate()->findOrFail($transaction->id);
        $transaction->load(['account' => fn ($query) => $query->where('user_id', $request->user()->id)]);
        $changes = [
            'description' => trim($validated['description']),
            'transaction_date' => $validated['transaction_date'],
            'category_id' => $validated['category_id'],
            'category_source' => 'user',
            'user_modified_description' => true,
            'user_modified_date' => true,
            'user_modified_category' => true,
        ];
        $currentMethod = in_array($transaction->payment_method, ['pix', 'card', 'debito', 'credito', 'dinheiro'], true)
            ? $transaction->payment_method : 'other';
        $automatic = (bool) ($validated['restore_automatic'] ?? false) || ($validated['payment_method'] ?? null) === 'auto';
        $selected = $validated['payment_method'] ?? 'keep';
        if ($automatic || ($selected !== 'keep' && $selected !== $currentMethod)) {
            $payload = $transaction->raw_payload ?? [
                'operationType' => $transaction->operation_type,
                'paymentData' => $transaction->payment_data,
                'type' => $transaction->direction,
            ];
            $changes['payment_method'] = $automatic
                ? app(PluggyTransactionClassifier::class)->classify($payload, $transaction->account?->type ?? 'BANK')['payment_method']
                : $selected;
            $changes['user_modified_payment_method'] = ! $automatic;
        }
        $transaction->update($changes);
        app(MonthlyBalanceService::class)->recalculateClosedFrom($request->user()->id, 0, 1);
        return $transaction;
        });

        return redirect()
            ->route('month.show', [$transaction->transaction_date->year, $transaction->transaction_date->month])
            ->with('success', 'Lançamento importado atualizado. Suas alterações serão mantidas nas próximas sincronizações.');
    }

    public function destroy(Request $request, int $transaction): RedirectResponse
    {
        $transaction = $this->transactionForUser($request, $transaction);
        DB::transaction(function () use ($transaction, $request) {
        $transaction->update([
            'deleted_by_user_at' => now(),
            'affects_totals' => false,
        ]);
        app(MonthlyBalanceService::class)->recalculateClosedFrom($request->user()->id, 0, 1);
        });

        return back()->with('success', 'Lançamento importado removido desta aplicação. Ele não voltará nas próximas sincronizações.');
    }

    private function transactionForUser(Request $request, int $transaction): PluggyTransaction
    {
        return PluggyTransaction::query()
            ->with([
                'category' => fn ($query) => $query->where('user_id', $request->user()->id),
                'account' => fn ($query) => $query->where('user_id', $request->user()->id),
                'connection' => fn ($query) => $query->where('user_id', $request->user()->id),
            ])
            ->where('user_id', $request->user()->id)
            ->whereNull('removed_at')
            ->whereNull('deleted_by_user_at')
            ->findOrFail($transaction);
    }
}
