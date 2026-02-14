<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public function create(array $data): void
    {
        DB::transaction(function () use ($data) {

            $categoryId = $this->resolveCategory($data);
            $data['category_id'] = $categoryId;

            if (!empty($data['is_installment'])) {
                $this->createInstallments($data);
            } else {
                $this->createSingleExpense($data);
            }

        });

    }

    private function resolveCategory(array $data) {
        if($data['category_id'] !== 'new') {
            return $data['category_id'];
        }

        $category = Category::create([
            'user_id' => auth()->id(),
            'name' => $data['new_category'],
            'type' => $data['type']
        ]);

        return $category->id;

    }

    private function createSingleExpense(array $data) {

        Expense::create([
                'user_id' => auth()->id(),
                'category_id' => $data['category_id'],
                'date' => $data['date'],
                'month' => $data['month'],
                'year' => $data['year'],
                'payment_mode' => $data['payment_mode'],
                'type' => $data['type'],
                'description' => $data['description'] ?? null,
                'amount' => $data['amount'],
                'is_installment' => false,
            ]);
    }

    private function createInstallments(array $data) {
        $installmentsGroup = Str::uuid();
        $totalInstallments = $data['total_installments'];
        $amount = $data['amount'];
        $valueInstallment = $amount / $totalInstallments;
        $baseDate = Carbon::createFromDate($data['year'], $data['month'], 1);
        
        
        for($i = 1; $i <= $totalInstallments; $i++) {
            $date = $baseDate->copy()->addMonths($i - 1);

            Expense::create([
                'user_id' => auth()->id(),
                'category_id' => $data['category_id'],
                'date' => $data['date'],
                'month' => $date->month,
                'year' => $date->year,
                'payment_mode' => $data['payment_mode'],
                'type' => $data['type'],
                'description' => $data['description'] ?? null,
                'amount' => $valueInstallment,
                'is_installment' => true,
                'current_installment' => $i,
                'total_installments' => $data['total_installments'],
                'installments_group' => $installmentsGroup,
            ]);
        }
    }


    public function update(Expense $expense, array $data)
    {
        DB::transaction(function () use ($expense, $data) {

            $data['category_id'] = $this->resolveCategory($data);

            $wasInstallment = !empty($expense->installments_group);
            $willBeInstallment = !empty($data['is_installment']);


            if (!$wasInstallment && $willBeInstallment) {

                $baseDate = Carbon::createFromDate(
                    $expense->year,
                    $expense->month,
                    1
                );
 
                $expense->delete();

                $data['month'] = $baseDate->month;
                $data['year']  = $baseDate->year;

                $this->createInstallments($data);

                return;
            }

            if ($wasInstallment && !$willBeInstallment) {

                $baseDate = Carbon::createFromDate(
                    $expense->year,
                    $expense->month,
                    1
                    )->subMonths($expense->current_installment - 1);
                    
                Expense::where('installments_group', $expense->installments_group)->delete();
                    
                $data['month'] = $baseDate->month;
                $data['year']  = $baseDate->year;
    
                $this->createSingleExpense($data);

                return;
            }

            if ($wasInstallment && $willBeInstallment) {

                $baseDate = Carbon::createFromDate(
                    $expense->year,
                    $expense->month,
                    1
                )->subMonths($expense->current_installment - 1);

                Expense::where('installments_group', $expense->installments_group)->delete();

                $data['month'] = $baseDate->month;
                $data['year']  = $baseDate->year;

                $this->createInstallments($data);

                return;
            }

            $this->updateSingleExpense($expense, $data);
        });
    }

    private function updateSingleExpense(Expense $expense, array $data) {
    
        $expense->update([
                'category_id' => $data['category_id'],
                'payment_mode' => $data['payment_mode'],
                'type' => $data['type'],
                'description' => $data['description'] ?? null,
                'amount' => $data['amount'],
            ]);

    }

    public function destroy(Expense $expense) {
        DB::transaction(function() use($expense) {
            if(!empty($expense->is_installment)) {
                Expense::where('installments_group', $expense->installments_group)->delete();
            } else {
                $expense->delete();
            }
        });
    }
}
