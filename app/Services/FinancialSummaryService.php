<?php

namespace App\Services;

use App\Models\PluggyTransaction;

class FinancialSummaryService
{
    /** @return array{income: float, expenses: float, pix_expenses: float} */
    public function importedMonthTotals(int $userId, int $year, int $month): array
    {
        $base = PluggyTransaction::query()->where('user_id', $userId)->forMonth($year, $month)->contributesToTotals();
        $income = (float) (clone $base)->economicIncome()->sum('amount');
        $normalExpenses = (float) (clone $base)->economicExpenses()->where('payment_method', '!=', 'pix')->sum('amount');
        $normalReversals = (float) (clone $base)->reversals()->where('payment_method', '!=', 'pix')->sum('amount');
        $pixExpenses = (float) (clone $base)->economicExpenses()->where('payment_method', 'pix')->sum('amount');
        $pixReversals = (float) (clone $base)->reversals()->where('payment_method', 'pix')->sum('amount');

        return ['income' => $income, 'expenses' => $normalExpenses - $normalReversals, 'pix_expenses' => $pixExpenses - $pixReversals];
    }

    /** @return array<int, float> */
    public function importedExpensesByMonth(int $userId, int $year): array
    {
        $totals = array_fill(1, 12, 0.0);
        $transactions = PluggyTransaction::query()
            ->where('user_id', $userId)
            ->whereYear('transaction_date', $year)
            ->contributesToTotals()
            ->whereIn('classification', [
                PluggyTransaction::CLASSIFICATION_EXPENSE,
                PluggyTransaction::CLASSIFICATION_FEE,
                PluggyTransaction::CLASSIFICATION_REFUND,
                PluggyTransaction::CLASSIFICATION_CASHBACK,
            ])
            ->get(['transaction_date', 'amount', 'classification']);

        foreach ($transactions as $transaction) {
            $multiplier = in_array($transaction->classification, [PluggyTransaction::CLASSIFICATION_REFUND, PluggyTransaction::CLASSIFICATION_CASHBACK], true) ? -1 : 1;
            $totals[$transaction->transaction_date->month] += $multiplier * (float) $transaction->amount;
        }

        return $totals;
    }

    /** @return array<int, float> */
    public function importedIncomeByMonth(int $userId, int $year): array
    {
        $totals = array_fill(1, 12, 0.0);
        $transactions = PluggyTransaction::query()
            ->where('user_id', $userId)
            ->whereYear('transaction_date', $year)
            ->contributesToTotals()
            ->economicIncome()
            ->get(['transaction_date', 'amount']);

        foreach ($transactions as $transaction) {
            $totals[$transaction->transaction_date->month] += (float) $transaction->amount;
        }

        return $totals;
    }
}
