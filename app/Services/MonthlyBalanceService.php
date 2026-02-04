<?php

namespace App\Services;

use App\Models\Expenses;
use App\Models\MonthlyBalance;

class MonthlyBalanceService
{
    /**
     * Create a new class instance.
     */
    public function calculate(int $year, int $month): array
    {
        $incomes = Expenses::where('type', 'income')
            ->where('year', $year)
            ->where('month', $month)
            ->sum('amount');

        $expenses = Expenses::where('type', 'expense')
            ->where('year', $year)
            ->where('month', $month)
            ->sum('amount');

        return [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'balance' => $incomes - $expenses
            ];
    }

    public function closeMonth(int $year, int $month, String $monthYear): void
    {
        $balance = $this->calculate($year, $month);

        MonthlyBalance::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'month' => $monthYear,
            ],
            [
                'closing_balance' => $balance['balance'],
            ]
        );
    }
}
