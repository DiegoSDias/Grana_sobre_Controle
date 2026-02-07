@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-linear-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-back-button />
        
        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <x-months-options :year="$year" :month="$month"/>

                <div class="flex gap-3">
                    <a href="{{ route('expenses.create', ['type' => 'income', 'year' => $year, 'month' => $month]) }}"
                       class="px-5 py-2.5 rounded-xl bg-linear-to-r from-green-600 to-green-500 text-white font-medium hover:from-green-700 hover:to-green-600 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Receita
                    </a>

                    <a href="{{ route('expenses.create', ['type' => 'expense', 'year' => $year, 'month' => $month]) }}"
                       class="px-5 py-2.5 rounded-xl bg-linear-to-r from-red-600 to-red-500 text-white font-medium hover:from-red-700 hover:to-red-600 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Despesa
                    </a>
                </div>
            </div>
        </div>

        {{-- RECEITAS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-linear-to-r from-green-50 to-emerald-50 p-5 border-b border-green-100">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                    <h2 class="text-xl font-bold text-green-700">Receitas</h2>
                </div>
            </div>
            
            <x-filter-incomes :categoriesIncome="$categoriesIncome"/>

            @if ($typeIncomes->isEmpty() && !$banlaceMonthPrevious)
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-slate-500 font-medium">Nenhuma receita cadastrada</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Categoria</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-green-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-600">-</td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">Sobra do mês passado</td>
                                <td class="px-6 py-4 text-right text-green-600 font-bold text-base">
                                    R$ {{ number_format($banlaceMonthPrevious, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4"></td>
                            </tr>
                            @foreach ($typeIncomes as $income)
                                <tr class="hover:bg-green-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $income->description }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $income->category?->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right text-green-600 font-bold text-base">
                                        R$ {{ number_format($income->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('expenses.edit', $income) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                                Editar
                                            </a>
                                            <form action="{{ route('expenses.destroy', $income) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-green-50 border-t-2 border-green-200">
                                <td class="px-6 py-4 font-bold text-slate-800" colspan="2">Total</td>
                                <td class="px-6 py-4 text-right text-green-700 font-bold text-lg">
                                    R$ {{ number_format($filteredIncomesTotal, 2, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- DESPESAS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-linear-to-r from-red-50 to-rose-50 p-5 border-b border-red-100">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                    <h2 class="text-xl font-bold text-red-700">Despesas</h2>
                </div>
            </div>

            <x-filter-expenses :categoriesExpense="$categoriesExpense"/>

            @if ($typeExpenses->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p class="text-slate-500 font-medium">Nenhuma despesa cadastrada</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Categoria</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Modo de Pagamento</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Parcelas</th>
                                <th class="px-6 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($typeExpenses as $expense)
                                <tr class="hover:bg-red-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $expense->description }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $expense->category?->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $expense->payment_mode }}</td>
                                    <td class="px-6 py-4 text-right text-red-600 font-bold text-base">
                                        R$ {{ number_format($expense->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 text-right">{{ $expense->current_installment ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                                Editar
                                            </a>
                                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-red-50 border-t-2 border-red-200">
                                <td class="px-6 py-4 font-bold text-slate-800" colspan="3">Total</td>
                                <td class="px-6 py-4 text-right text-red-700 font-bold text-lg">
                                    R$ {{ number_format($filteredExpensesTotal, 2, ',', '.') }}
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- RESUMO --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-linear-to-r from-indigo-50 to-blue-50 p-5 border-b border-indigo-100">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <h2 class="text-xl font-bold text-indigo-700">Resumo do Mês</h2>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-slate-600 font-medium">Entradas do mês</span>
                    <span class="text-green-600 font-bold text-lg">
                        R$ {{ number_format($incomesBalance, 2, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-slate-600 font-medium">Despesas pagas à vista (Pix)</span>
                    <span class="text-green-600 font-bold text-lg">
                        R$ {{ number_format($expensesPix, 2, ',', '.') }}
                    </span>
                </div>

                <div class="border-t-2 border-slate-200 pt-4"></div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-slate-700 font-semibold">Saldo líquido disponível</span>
                    <span class="text-green-600 font-bold text-lg">
                        R$ {{ number_format(($incomesBalance - $expensesPix), 2, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                    <span class="text-slate-700 font-semibold">Total de despesas do mês</span>
                    <span class="text-red-600 font-bold text-lg">
                        R$ {{ number_format($expensesBalance, 2, ',', '.') }}
                    </span>
                </div>

                <div class="border-t-2 border-slate-200 pt-4"></div>

                <div class="flex justify-between items-center py-4 bg-linear-to-r from-slate-50 to-slate-100 rounded-xl px-4">
                    <span class="text-slate-800 font-bold text-lg">Saldo final do mês</span>
                    <span class="font-bold text-2xl {{ $balanceAvailable >= 0 ? 'text-green-700' : 'text-red-700' }}">
                        R$ {{ number_format($balanceAvailable, 2, ',', '.') }}
                    </span>
                </div>

                <form action="{{ route('month.close', [$year, $month]) }}" method="POST" class="mt-6">
                    @csrf
                    <button class="w-full px-6 py-3 bg-linear-to-r from-indigo-600 to-indigo-500 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-600 transition-all duration-200 shadow-sm hover:shadow-md">
                        Fechar Mês
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection