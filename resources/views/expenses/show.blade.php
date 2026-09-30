<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-6 animate-fade-in">
                <a href="{{ url()->previous() }}"
                   class="group inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors mb-4">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm font-medium">Voltar</span>
                </a>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl {{ $expense->type === 'income' ? 'bg-gradient-to-br from-emerald-500 to-green-500' : 'bg-gradient-to-br from-rose-500 to-red-500' }} flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18h.01M12 6h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-light text-slate-900">
                            Detalhes da {{ $expense->type === 'income' ? 'Receita' : 'Despesa' }}
                        </h1>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 animate-slide-up">
                <div class="space-y-6">

                    {{-- Descrição --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Descrição
                        </label>
                        <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            {{ $expense->description }}
                        </div>
                    </div>

                    {{-- Data --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Data
                        </label>
                        <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}
                        </div>
                    </div>

                    {{-- Valor --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Valor
                        </label>
                        <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            R$ {{ number_format($expense->amount, 2, ',', '.') }}
                        </div>
                    </div>

                    {{-- Categoria --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Categoria
                        </label>
                        <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            {{ $expense->category->name ?? 'Sem categoria' }}
                        </div>
                    </div>

                    {{-- Forma de pagamento --}}
                    @if ($expense->type === 'expense')
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Forma de pagamento
                            </label>
                            <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $expense->payment_mode === 'pix' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">

                                    {{ ucfirst($expense->payment_mode) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Parcelamento --}}
                    @if ($expense->is_installment)
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Parcelamento
                            </label>
                            <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-900">
                                {{ $expense->current_installment }} / {{ $expense->total_installments }} parcelas
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

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

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }
    </style>
</x-app-layout>
