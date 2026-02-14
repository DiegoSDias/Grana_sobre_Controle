<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\MonthlyBalance;

class MonthlyBalanceService
{
    /**
     * Create a new class instance.
     */
    public function calculate(int $year, int $month): array
    {
        $incomes = Expense::where('type', 'income')
            ->where('year', $year)
            ->where('month', $month)
            ->sum('amount');


        if ($month == 1) {
            $previousMonthNumber = 12;
            $previousYear = $year - 1;
        } else {
            $previousMonthNumber = $month - 1;
            $previousYear = $year;
        }

        $previousBalance = MonthlyBalance::where('user_id', auth()->id())
            ->where('year', $previousYear)
            ->where('month', $previousMonthNumber)
            ->first();

        $balanceMonthPrevious = $previousBalance?->closing_balance ?? 0;
        
        $incomes += $balanceMonthPrevious;

        $expensesNormal = Expense::where('type', 'expense')
            ->where('year', $year)
            ->where('month', $month)
            ->where('payment_mode', '!=', 'pix')
            ->sum('amount');

        $expensesPix = Expense::where('type', 'expense')
            ->where('year', $year)
            ->where('month', $month)
            ->where('payment_mode', 'pix')
            ->sum('amount');

        $balanceMonth = $incomes - $expensesNormal;
        $balanceAvailable = $balanceMonth - $expensesPix;

        return [
            'incomes' => $incomes,
            'expenses' => $expensesNormal,
            'expensesPix' => $expensesPix,
            'balance' => $balanceMonth,
            'balanceAvailable' => $balanceAvailable,
            'balanceMonthPrevious' => $balanceMonthPrevious
            ];
    }

    public function closeMonth(int $year, int $month): void
    {
        $balance = $this->calculate($year, $month);

        MonthlyBalance::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'year' => $year,
                'month' => $month,
            ],
            [
                'closing_balance' => $balance['balanceAvailable'],
            ]
        );
    }
}
