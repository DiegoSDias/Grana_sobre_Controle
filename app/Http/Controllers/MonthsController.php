<?php

namespace App\Http\Controllers;

use App\Models\Categories;
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

    public function show(Request $request ,String $year, String $month) {

        $expenses = Expenses::where('month', $month)
            ->where('year', $year)
            ->get();

        $categoriesIncome = Categories::where('type', 'income')
                                ->get();

        $categoriesExpense = Categories::where('type', 'expense')
                                ->get();

        $typeIncomes = Expenses::with('category')
                                ->where('type', 'income')
                                ->where('month', $month)
                                ->where('year', $year)
                                ->when($request->income_category, function ($q) use ($request) {
                                    $q->where('category_id', $request->income_category);
                                })
                                ->when($request->income_value, function ($q) use ($request) {
                                    $q->where('amount', $request->income_value_op, $request->income_value);
                                })
                                ->get();

        $typeExpenses = Expenses::with('category')
                                ->where('type', 'expense')
                                ->where('month', $month)
                                ->where('year', $year)
                                ->when($request->expense_category, function($q) use ($request) {
                                    $q->where('category_id', $request->expense_category);
                                })
                                ->when($request->payment_mode, function($q) use ($request) {
                                    $q->where('payment_mode', $request->payment_mode);
                                })
                                ->when($request->is_installment !== null, function($q) use ($request) {
                                    $q->where('is_installment', $request->is_installment);
                                })
                                ->when($request->expense_value, function($q) use ($request) {
                                    $q->where('amount', $request->expense_value_op, $request->expense_value);
                                })
                                ->get();
        
        $filteredIncomesTotal = $typeIncomes->sum('amount');
        $filteredExpensesTotal = $typeExpenses->sum('amount');
        
        $values = $this->monthlyBalanceService->calculate($year, $month);
          
        $incomesBalance = $values['incomes'];
        $expensesBalance = $values['expenses'];
        $expensesPix = $values['expensesPix'];
        $balanceAvailable = $values['balanceAvailable'];
        $balance = $values['balance'];
        $banlaceMonthPrevious = $values['banlaceMonthPrevious'];

        return view('months.show', compact(
                                            'expenses',
                                            'categoriesIncome',
                                            'categoriesExpense',
                                            'filteredIncomesTotal',
                                            'filteredExpensesTotal',
                                            'year', 
                                            'month', 
                                            'typeIncomes', 
                                            'typeExpenses',
                                            'incomesBalance', 
                                            'expensesBalance',
                                            'expensesPix',
                                            'balanceAvailable',
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
