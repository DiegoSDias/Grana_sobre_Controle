<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
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

        $expenses = Expense::where('month', $month)
            ->where('year', $year)
            ->get();

        $categoriesIncome = Category::where('type', 'income')
                                ->get();

        $categoriesExpense = Category::where('type', 'expense')
                                ->get();

        $typeIncomes = Expense::with('category')
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

        $typeExpenses = Expense::with('category')
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
        
        $values = $this->monthlyBalanceService->calculate($year, $month);
          
        $incomesBalance = $values['incomes'];
        $expensesBalance = $values['expenses'];
        $expensesPix = $values['expensesPix'];
        $balanceAvailable = $values['balanceAvailable'];
        $balance = $values['balance'];
        $balanceMonthPrevious = $values['balanceMonthPrevious'];

        $filteredIncomesTotal = $typeIncomes->sum('amount') + $balanceMonthPrevious;
        $filteredExpensesTotal = $typeExpenses->sum('amount');

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
                                            'balanceMonthPrevious'
                                            ));
    }

    public function close(int $year, int $month) {
        $this->monthlyBalanceService->closeMonth($year, $month);

        return back()->with('success', 'Mês fechado com sucesso.');
    }
}
