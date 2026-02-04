@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                {{ $month }} / {{ $year }}
            </h1>
            <p class="text-slate-500">Resumo mensal</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('expenses.create', ['type' => 'income', 'year' => $year, 'month' => $month]) }}"
               class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                + Receita
            </a>

            <a href="{{ route('expenses.create', ['type' => 'expense', 'year' => $year, 'month' => $month]) }}"
               class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                + Despesa
            </a>
        </div>
    </div>

    {{-- RECEITAS --}}
    <div class="bg-white rounded-xl shadow">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-green-600">Receitas</h2>
        </div>

        @if ($typeIncomes->isEmpty() && !$banlaceMonthPrevious)
            <p class="p-4 text-slate-500">Nenhuma receita cadastrada.</p>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Descrição</th>
                        <th class="px-4 py-2 text-left">Categoria</th>
                        <th class="px-4 py-2 text-right">Valor</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2">-</td>
                            <td class="px-4 py-2">Sobra do mês passado</td>
                            <td class="px-4 py-2 text-right text-green-600 font-medium">
                                R$ {{ number_format($banlaceMonthPrevious, 2, ',', '.') }}
                            </td>
                    </tr>
                    @foreach ($typeIncomes as $income)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $income->description }}</td>
                            <td class="px-4 py-2">{{ $income->category?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-right text-green-600 font-medium">
                                R$ {{ number_format($income->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('expenses.edit', $income) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>
                               <form action="{{ route('expenses.destroy', $income) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:underline">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                        <tr class="border-t bg-slate-50 font-semibold">
                            <td class="px-4 py-2" colspan="2">Total</td>
                            <td class="px-4 py-2 text-right text-green-700">
                                R$ {{ number_format($incomesBalance, 2, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        @endif
    </div>

    {{-- DESPESAS --}}
    <div class="bg-white rounded-xl shadow">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-red-600">Despesas</h2>
        </div>

        @if ($typeExpenses->isEmpty())
            <p class="p-4 text-slate-500">Nenhuma despesa cadastrada.</p>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Descrição</th>
                        <th class="px-4 py-2 text-left">Categoria</th>
                        <th class="px-4 py-2 text-right">Valor</th>
                        <th class="px-4 py-2 text-right">Parcelas</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($typeExpenses as $expense)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $expense->description }}</td>
                            <td class="px-4 py-2">{{ $expense->category?->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-right text-red-600 font-medium">
                                R$ {{ number_format($expense->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">{{ $expense->current_installment ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:underline">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border-t bg-slate-50 font-semibold">
                        <td class="px-4 py-2" colspan="2">Total</td>
                        <td class="px-4 py-2 text-right text-red-700">
                            R$ {{ number_format($expensesBalance, 2, ',', '.') }}
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold text-slate-700 mb-4">
        Resumo do mês
    </h2>

    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="text-slate-600">Total de receitas</span>
            <span class="text-green-600 font-medium">
                R$ {{ number_format($incomesBalance, 2, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-600">Total de despesas</span>
            <span class="text-red-600 font-medium">
                R$ {{ number_format($expensesBalance, 2, ',', '.') }}
            </span>
        </div>

        <hr>

        <div class="flex justify-between text-base font-bold">
            <span>Saldo do mês</span>
            <span class="{{ $balance >= 0 ? 'text-green-700' : 'text-red-700' }}">
                R$ {{ number_format($balance, 2, ',', '.') }}
            </span>
        </div>
    </div>
    
    <form action="{{ route('month.close', [$year, $month]) }}" method="POST">
        @csrf
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">
            Fechar mês
        </button>
    </form>
</div>

</div>
@endsection
