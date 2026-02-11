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

        $currentMonth = $year . '-' . $month;
        $previousMonth = MonthlyBalance::where('user_id', auth()->id())
        ->where('month', '<', $currentMonth)
        ->orderBy('month', 'desc')
        ->first();
        
        $banlaceMonthPrevious = $previousMonth?->closing_balance ?? 0;
        
        $incomes += $banlaceMonthPrevious;

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
            'banlaceMonthPrevious' => $banlaceMonthPrevious
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
                'closing_balance' => $balance['balanceAvailable'],
            ]
        );
    }
}
