<?php

namespace App\Http\Controllers\Pluggy;

use App\Http\Controllers\Controller;
use App\Models\PluggyTransactionRule;
use App\Services\Pluggy\PluggyTransactionRuleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PluggyTransactionRuleController extends Controller
{
    public function store(Request $request, PluggyTransactionRuleService $ruleService): RedirectResponse
    {
        $validated = $request->validate([
            'phrase' => ['required', 'string', 'min:3', 'max:150'],
            'action' => ['required', 'in:' . implode(',', [
                PluggyTransactionRule::ACTION_EXCLUDE,
                PluggyTransactionRule::ACTION_INTERNAL_TRANSFER,
            ])],
        ]);

        PluggyTransactionRule::query()->firstOrCreate([
            'user_id' => $request->user()->id,
            'phrase' => trim($validated['phrase']),
            'action' => $validated['action'],
        ], ['is_active' => true]);

        $ruleService->reclassifyForUser($request->user()->id);

        return back()->with('success', 'Regra salva e movimentações existentes atualizadas.');
    }

    public function destroy(Request $request, PluggyTransactionRule $rule, PluggyTransactionRuleService $ruleService): RedirectResponse
    {
        abort_unless($rule->user_id === $request->user()->id, 404);

        $rule->delete();
        $ruleService->reclassifyForUser($request->user()->id);

        return back()->with('success', 'Regra removida e movimentações recalculadas.');
    }

    public function update(Request $request, PluggyTransactionRule $rule, PluggyTransactionRuleService $ruleService): RedirectResponse
    {
        abort_unless($rule->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'phrase' => ['required', 'string', 'min:3', 'max:150'],
            'action' => ['required', 'in:' . implode(',', [
                PluggyTransactionRule::ACTION_EXCLUDE,
                PluggyTransactionRule::ACTION_INTERNAL_TRANSFER,
            ])],
        ]);

        $phrase = trim($validated['phrase']);
        $duplicate = PluggyTransactionRule::query()
            ->where('user_id', $request->user()->id)
            ->where('phrase', $phrase)
            ->where('action', $validated['action'])
            ->where('id', '!=', $rule->id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['phrase' => 'Já existe uma regra igual.'])->withInput();
        }

        $rule->update(['phrase' => $phrase, 'action' => $validated['action']]);
        $ruleService->reclassifyForUser($request->user()->id);

        return back()->with('success', 'Regra atualizada e movimentações recalculadas.');
    }
}
