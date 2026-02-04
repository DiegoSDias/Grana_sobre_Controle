<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\MonthlyBalance;
use App\Services\MonthlyBalanceService;
use Illuminate\Http\Request;


class MonthsController extends Controller
{
    protected MonthlyBalanceService $monthlyBalanceService;
    
    public function __construct(MonthlyBalanceService $monthlyBalanceService) {
        $this->monthlyBalanceService = $monthlyBalanceService;
    }

    public function show(String $year, String $month) {
        $expenses = Expenses::where('month', $month)
            ->where('year', $year)
            ->get();

        $typeIncomes = Expenses::with('category')
                                ->where('type', 'income')
                                ->where('month', $month)
                                ->where('year', $year)
                                ->get();
        
        $typeExpenses = Expenses::with('category')
                                ->where('type', 'expense')
                                ->where('month', $month)
                                ->where('year', $year)
                                ->get();
        
        $values = $this->monthlyBalanceService->calculate($year, $month);
        
        $currentMonth = $year . '-' . $month;
        $previousMonth = MonthlyBalance::where('user_id', auth()->id())
        ->where('month', '<', $currentMonth)
        ->orderBy('month', 'desc')
        ->first();
        
        $banlaceMonthPrevious = $previousMonth?->closing_balance ?? 0;
        
        $incomesBalance = $values['incomes'] + $banlaceMonthPrevious;
        $expensesBalance = $values['expenses'];
        $balance = $values['balance'] + $banlaceMonthPrevious;

        return view('months.show', compact(
                                            'expenses', 
                                            'year', 
                                            'month', 
                                            'typeIncomes', 
                                            'typeExpenses',
                                            'incomesBalance', 
                                            'expensesBalance' ,
                                            'balance',
                                            'banlaceMonthPrevious'
                                            ));
    }

    public function close(int $year, int $month) {
        $monthYear = $year . '-' . $month;
        $this->monthlyBalanceService->closeMonth($year, $month, $monthYear);

        return back()->with('success', 'Mês fechado com sucesso.');
    }
}
