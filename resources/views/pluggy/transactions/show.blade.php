<x-app-layout>
    @php($isIncome = $transaction->classification === \App\Models\PluggyTransaction::CLASSIFICATION_INCOME)
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="mx-auto max-w-3xl px-4">
            <a href="{{ route('month.show', [$transaction->transaction_date->year, $transaction->transaction_date->month]) }}" class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900">← Voltar ao mês</a>
            <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-widest text-blue-600">Importado pela Pluggy</p>
                        <h1 class="mt-2 text-3xl font-light text-slate-900">{{ $isIncome ? 'Detalhes da receita' : 'Detalhes da despesa' }}</h1>
                    </div>
                    <a href="{{ route('pluggy.transactions.edit', $transaction) }}" class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">Editar</a>
                </div>

                <dl class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2"><dt class="text-sm font-medium text-slate-500">Descrição</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->description }}</dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Data</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->transaction_date->format('d/m/Y') }}</dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Valor</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 font-semibold {{ $isIncome ? 'text-emerald-700' : 'text-rose-700' }}">R$ {{ number_format($transaction->display_amount, 2, ',', '.') }}</dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Categoria</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->category?->name ?? 'Sem categoria' }}</dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Conta</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->account?->name ?? '—' }}</dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Forma de pagamento</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->payment_label }} <span class="text-xs text-slate-500">({{ $transaction->user_modified_payment_method ? 'definida por você' : 'classificação automática' }})</span></dd></div>
                    <div><dt class="text-sm font-medium text-slate-500">Situação na instituição</dt><dd class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-900">{{ $transaction->status === 'POSTED' ? 'Confirmada' : 'Pendente' }}</dd></div>
                </dl>

                <form class="mt-8 border-t border-slate-100 pt-6" method="POST" action="{{ route('pluggy.transactions.destroy', $transaction) }}" onsubmit="return confirm('Remover este lançamento importado desta aplicação? Ele não será restaurado nas próximas sincronizações.')">
                    @csrf @method('DELETE')
                    <button class="rounded-xl border border-red-200 px-4 py-2.5 text-sm font-medium text-red-700 hover:bg-red-50">Excluir lançamento</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
