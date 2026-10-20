<?php

namespace App\Http\Controllers\Pluggy;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PluggyTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        ]);

        if ($validated['category_id'] !== null && ! Category::query()
            ->whereKey($validated['category_id'])
            ->where('user_id', $request->user()->id)
            ->where('type', $categoryType)
            ->exists()) {
            return back()->withErrors(['category_id' => 'Escolha uma categoria válida.'])->withInput();
        }

        $transaction->update([
            'description' => trim($validated['description']),
            'transaction_date' => $validated['transaction_date'],
            'category_id' => $validated['category_id'],
            'category_source' => 'user',
            'user_modified_description' => true,
            'user_modified_date' => true,
            'user_modified_category' => true,
        ]);

        return redirect()
            ->route('month.show', [$transaction->transaction_date->year, $transaction->transaction_date->month])
            ->with('success', 'Lançamento importado atualizado. Suas alterações serão mantidas nas próximas sincronizações.');
    }

    public function destroy(Request $request, int $transaction): RedirectResponse
    {
        $transaction = $this->transactionForUser($request, $transaction);
        $transaction->update([
            'deleted_by_user_at' => now(),
            'affects_totals' => false,
        ]);

        return back()->with('success', 'Lançamento importado removido desta aplicação. Ele não voltará nas próximas sincronizações.');
    }

    private function transactionForUser(Request $request, int $transaction): PluggyTransaction
    {
        return PluggyTransaction::query()
            ->with(['category', 'account', 'connection'])
            ->where('user_id', $request->user()->id)
            ->whereNull('removed_at')
            ->whereNull('deleted_by_user_at')
            ->findOrFail($transaction);
    }
}
