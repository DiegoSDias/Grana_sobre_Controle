<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Str;

class ExpensesController extends Controller
{

    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $year = $request->year;
        $month = $request->month;
        $categories = Category::where('type', $type)->get();
        
        return view('expenses.create', compact('type', 'year', 'month', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'nullable',
            'new_category' => 'nullable|string|max:100',
            'payment_mode' => 'required|in:pix,cartao',
            'type' => 'required|in:income,expense',
            'is_installment' => 'boolean',
            'total_installments' => 'nullable|required_if:is_installment,true|integer|min:2'
        ]);

        $data['date'] = now()->format('Y-m-d');
        $data['year'] = $request->year;
        $data['month'] = $request->month;

        $this->expenseService->create($data);
        
        return redirect()
            ->route('month.show', [ $data['year'], $data['month']])
            ->with('success', 'Despesa criada com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $expense = Expense::where('id', $id)->first();
        $type = $expense->type;
        $year = $expense->year;
        $month = $expense->month;
        $categories = Category::where('type', $type)->get();
        if($expense->is_installment) {
            $expense->amount = round($expense->total_installments * $expense->amount);
        }

        return view('expenses.edit', compact('expense', 'type', 'year', 'month', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'nullable',
            'new_category' => 'nullable|string|max:100',
            'payment_mode' => 'required|in:pix,cartao',
            'type' => 'required|in:income,expense',
            'is_installment' => 'boolean',
            'total_installments' => 'nullable|required_if:is_installment,true|integer|min:2'
        ]);

        $data['year'] = $request->year;
        $data['month'] = $request->month;
        $data['date'] = now()->format('Y-m-d');

        if(!empty($data['is_installment'])) {
            $expense = Expense::findOrFail($id);
            $data['current_installment'] = $expense->current_installment;
            if($expense->installments_group) {
                $expense = Expense::where('installments_group', $expense->installments_group)
                                    ->firstOrFail();
            }
        } else {
             $expense = Expense::findOrFail($id);
        }
        
        $this->expenseService->update($expense, $data);
        
        return redirect()
            ->route('month.show', [ $data['year'], $data['month']])
            ->with('success', 'Despesa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->expenseService->destroy($expense);

        return redirect()
            ->back()
            ->with('success', 'Despesa excluída com sucesso');
    }
}
