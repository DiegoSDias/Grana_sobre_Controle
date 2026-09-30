<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\MonthlyBalance;
use App\Support\Months;
use Illuminate\Support\Facades\Auth;

class HomeService
{
    public function index(int $anoSelecionado)
    {
        $meses = Months::MONTHS;

        $incomeBalance = Expense::FromUser(Auth::id())
            ->income()
            ->year($anoSelecionado)
            ->groupedByMonth()
            ->pluck('total', 'month');

        $closingBalances = MonthlyBalance::FromUser(Auth::id())
            ->year($anoSelecionado)
            ->pluck('closing_balance', 'month');

        $finalIncomeBalance = [];

        foreach (range(1, 12) as $mes) {
            $receitaMes = $incomeBalance[$mes] ?? 0;
            $saldoAnterior = $closingBalances[$mes - 1] ?? 0;
            $finalIncomeBalance[$mes] = $receitaMes + $saldoAnterior;
        }

        $expenseBalance = Expense::FromUser(Auth::id())
            ->expense()
            ->year($anoSelecionado)
            ->groupedByMonth()
            ->pluck('total', 'month');

        $totalExpense = Expense::FromUser(Auth::id())
            ->expense()
            ->year($anoSelecionado)
            ->sum('amount');

        $mediaAnual = $expenseBalance->count()
            ? $totalExpense / $expenseBalance->count()
            : 0;

        $maiorGasto = $expenseBalance->max();

        return [
            'meses' => $meses,
            'finalIncomeBalance' => $finalIncomeBalance,
            'expenseBalance' => $expenseBalance,
            'totalExpense' => $totalExpense,
            'mediaAnual' => $mediaAnual,
            'maiorGasto' => $maiorGasto
        ];
    }
}
