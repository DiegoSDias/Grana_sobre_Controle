<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header Section -->
            <header class="mb-12 animate-fade-in">
                <div class="flex items-end justify-between">
                    <div>
                        <h1 class="text-5xl font-light text-slate-900 mb-2 tracking-tight">
                            Controle de Gastos
                        </h1>
                        <p class="text-slate-500 text-base font-light">
                            Acompanhe suas finanças mensalmente
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-400 font-medium uppercase tracking-wider mb-3">Ano</p>
                        <div class="flex items-center gap-3 justify-end">
                            @php
                                $anoAtual = $anoSelecionado;
                                $anoAnterior = $anoAtual - 1;
                                $anoProximo = $anoAtual + 1;
                            @endphp
                            
                            <!-- Botão Anterior -->
                            <a href="?year={{ $anoAnterior }}" 
                               class="group w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            
                            <!-- Ano Atual -->
                            <div class="relative group">
                                <div class="text-4xl font-light text-slate-900 px-4 py-2 bg-white rounded-xl border border-slate-200 shadow-sm min-w-[140px] text-center cursor-pointer hover:border-blue-300 transition-all duration-200">
                                    {{ $anoAtual }}
                                </div>
                                
                                <!-- Dropdown de Anos -->
                                <div class="absolute top-full right-0 mt-2 bg-white rounded-xl border border-slate-200 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 min-w-[140px]">
                                    <div class="py-2 max-h-64 overflow-y-auto scrollbar-thin">
                                        @foreach(range($anoSelecionado + 3, $anoSelecionado - 3) as $ano)
                                            <a href="?year={{ $ano }}" 
                                               class="block px-4 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ $ano == $anoAtual ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                                {{ $ano }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botão Próximo -->
                            <a href="?year={{ $anoProximo }}" 
                               class="group w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Year Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate-slide-up">
                <!-- Total Card -->
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-600 uppercase tracking-wide">Total Anual</span>
                        </div>
                        <p class="text-4xl font-light text-slate-900 mb-1">
                            R$ {{ number_format($totalAnual ?? 0, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-slate-400">Acumulado em {{ $anoSelecionado }}</p>
                    </div>
                </div>

                <!-- Average Card -->
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/5 to-transparent rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-600 uppercase tracking-wide">Média Mensal</span>
                        </div>
                        <p class="text-4xl font-light text-slate-900 mb-1">
                            R$ {{ number_format($mediaAnual ?? 0, 2, ',', '.') }}
                        </p>
                        <p class="text-xs text-slate-400">Por mês em {{ $anoSelecionado }}</p>
                    </div>
                </div>

                <!-- Highest Card -->
                <div class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/5 to-transparent rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-600 uppercase tracking-wide">Maior Gasto</span>
                        </div>
                        <p class="text-4xl font-light text-slate-900 mb-1">
                            @if (isset($maiorGasto) && $maiorGasto > 0)
                                R$ {{ number_format($maiorGasto, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </p>
                        <p class="text-xs text-slate-400">Pico em um mês</p>
                    </div>
                </div>
            </div>

            <!-- Months Grid -->
            <div class="mb-8">
                <h2 class="text-2xl font-light text-slate-900 mb-6">Meses</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($meses as $mes)
                        <a href="{{ route('month.show', ['year' => $anoSelecionado, 'month' => $mes['numero']]) }}"
                            class="group relative overflow-hidden bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 hover:border-slate-200 animate-scale-in"
                            style="animation-delay: {{ $loop->index * 0.05 }}s">
                            
                            <!-- Gradient Background -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $mes['cor'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Content -->
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <p class="text-sm font-medium text-slate-400 uppercase tracking-wider mb-1 group-hover:text-white/80 transition-colors">
                                            Mês {{ str_pad($mes['numero'], 2, '0', STR_PAD_LEFT) }}
                                        </p>
                                        <h3 class="text-2xl font-light text-slate-900 group-hover:text-white transition-colors">
                                            {{ $mes['nome'] }}
                                        </h3>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-white transition-all duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                
                                <div class="space-y-1">
                                    <p class="text-xs text-slate-400 uppercase tracking-wide group-hover:text-white/70 transition-colors">Total</p>
                                    <p class="text-2xl font-light text-slate-900 group-hover:text-white transition-colors">
                                        R$ {{ number_format($gastosPorMes[$mes['numero']] ?? 0, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out 0.2s backwards;
        }

        .animate-scale-in {
            animation: scale-in 0.4s ease-out backwards;
        }

        /* Custom Scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-app-layout>