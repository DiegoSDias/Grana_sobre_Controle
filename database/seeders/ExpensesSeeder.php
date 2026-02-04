<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'date' => now()->startOfMonth(),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'income',
            'description' => 'Salário mensal',
            'amount' => 3500.00,
            'is_installment' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('expenses')->insert([
            'user_id' => 1,
            'category_id' => 2,
            'date' => now()->subDays(3),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'expense',
            'description' => 'Uber para o trabalho',
            'amount' => 28.90,
            'is_installment' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('expenses')->insert([
            'user_id' => 1,
            'category_id' => 3,
            'date' => now()->subDays(10),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'expense',
            'description' => 'Assinatura Netflix',
            'amount' => 55.90,
            'is_installment' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $installmentGroup = Str::uuid();

        DB::table('expenses')->insert([
            'user_id' => 2,
            'category_id' => 6,
            'date' => now()->startOfMonth(),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'expense',
            'description' => 'Celular parcelado 1/12',
            'amount' => 120.00,
            'is_installment' => true,
            'current_installment' => 1,
            'total_installments' => 12,
            'installments_group' => $installmentGroup,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('expenses')->insert([
            'user_id' => 2,
            'category_id' => 5,
            'date' => now()->subDays(2),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'expense',
            'description' => 'Passagem de ônibus',
            'amount' => 5.20,
            'is_installment' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('expenses')->insert([
            'user_id' => 2,
            'category_id' => 7,
            'date' => now()->subDays(1),
            'month' => now()->month,
            'year' => now()->year,
            'type' => 'expense',
            'description' => 'Pedido no iFood',
            'amount' => 42.80,
            'is_installment' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
