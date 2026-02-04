@extends('layouts.app')

@section('content')
    <div class="min-h-screen p-6">

        <div class="max-w-7xl mx-auto">
            <header class="mb-6">
                <h1 class="text-xl font-semibold mb-1">
                    Controle de Gastos
                </h1>
                <p class="text-slate-400 text-sm">
                    Selecione um mês para visualizar e adicionar seus gastos
                </p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach ($meses as $mes)
                    <a href="{{ route('month.show', ['year' => 2026, 'month' => $mes['numero']]) }}"
                        class="bg-linear-to-br {{ $mes['cor'] }} rounded-3xl p-6 cursor-pointer hover:scale-105 transition-transform">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="text-white/70 text-2xl font-bold">{{ $mes['numero'] }}</span>
                                <span class="text-white text-xl font-semibold">{{ $mes['nome'] }}</span>
                            </div>
                            <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-white/80 text-sm">Total gasto</span>
                            <span class="text-white text-lg font-semibold">
                                R$ {{ number_format($gastosPorMes[$mes['numero']] ?? 0, 2, ',', '.') }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Resumo do Ano -->
            <div class="bg-zinc-500 rounded-3xl p-8 border border-zinc-800">
                <h2 class="text-gray-400 text-lg mb-6">Resumo do Ano</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Total -->
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm">Total</span>
                        </div>
                        <span class="text-white text-3xl font-bold">
                            R$ {{ number_format($totalAnual ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <!-- Média -->
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span class="text-sm">Média</span>
                        </div>
                        <span class="text-green-500 text-3xl font-bold">
                            R$ {{ number_format($mediaAnual ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <!-- Maior -->
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-sm">Maior</span>
                        </div>
                        <span class="text-white text-3xl font-bold">
                            @if (isset($maiorGasto) && $maiorGasto > 0)
                                R$ {{ number_format($maiorGasto, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
