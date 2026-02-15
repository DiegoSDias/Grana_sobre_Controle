<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\MonthlyBalance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
       $meses = [
            // VERÃO
            ['numero' => '1',  'nome' => 'Janeiro',   'cor' => 'bg-yellow-400'],
            ['numero' => '2',  'nome' => 'Fevereiro', 'cor' => 'bg-orange-400'],
            
            // OUTONO
            ['numero' => '3', 'nome' => 'Março', 'cor' => 'bg-amber-600'],
            ['numero' => '4', 'nome' => 'Abril', 'cor' => 'bg-orange-600'],
            ['numero' => '5', 'nome' => 'Maio',  'cor' => 'bg-amber-700'],
            
            // INVERNO
            ['numero' => '6', 'nome' => 'Junho',  'cor' => 'bg-sky-600'],
            ['numero' => '7', 'nome' => 'Julho',  'cor' => 'bg-blue-600'],
            ['numero' => '8', 'nome' => 'Agosto', 'cor' => 'bg-indigo-600'],
            
            // PRIMAVERA
            ['numero' => '9',  'nome' => 'Setembro', 'cor' => 'bg-green-400'],
            ['numero' => '10', 'nome' => 'Outubro',  'cor' => 'bg-emerald-400'],
            ['numero' => '11', 'nome' => 'Novembro', 'cor' => 'bg-cyan-400'],

            ['numero' => '12', 'nome' => 'Dezembro',  'cor' => 'bg-red-400'],
        ];

        $anoSelecionado = $request->year ?? date('Y');

            $incomeBalance = Expense::where('type', 'income')
                ->where('year', $anoSelecionado)
                ->selectRaw('month, SUM(amount) as total')
                ->groupBy('month')
                ->pluck('total', 'month');

            $closingBalances = MonthlyBalance::where('user_id', auth()->id())
                ->where('year', $anoSelecionado)
                ->pluck('closing_balance', 'month');

            $finalIncomeBalance = [];

            foreach (range(1, 12) as $mes) {
                $receitaDoMes = $incomeBalance[$mes] ?? 0;
                $saldoAnterior = $closingBalances[$mes - 1] ?? 0;
                $finalIncomeBalance[$mes] = $receitaDoMes + $saldoAnterior;
            }


            $expenseBalance = Expense::where('type', 'expense')
                ->where('year', $anoSelecionado)
                ->selectRaw('month, SUM(amount) as total')
                ->groupBy('month')
                ->pluck('total', 'month');

            $totalExpense = Expense::where('type', 'expense')
                ->where('year', $anoSelecionado)
                ->sum('amount');

            $mediaAnual = $totalExpense / count($expenseBalance);
            $maiorGasto = $expenseBalance->max();
 
        return view('dashboard', compact('meses', 
                                        'anoSelecionado', 
                                        'expenseBalance',
                                        'finalIncomeBalance',
                                        'totalExpense',
                                        'mediaAnual',
                                        'maiorGasto'));
}
}
