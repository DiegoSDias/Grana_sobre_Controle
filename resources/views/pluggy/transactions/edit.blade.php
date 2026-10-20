<x-app-layout>
    @php($isIncome = $transaction->classification === \App\Models\PluggyTransaction::CLASSIFICATION_INCOME)
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="mx-auto max-w-3xl px-4">
            <a href="{{ route('pluggy.transactions.show', $transaction) }}" class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900">← Voltar aos detalhes</a>
            <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-widest text-blue-600">Importado pela Pluggy</p>
                <h1 class="mt-2 text-3xl font-light text-slate-900">Editar {{ $isIncome ? 'receita' : 'despesa' }}</h1>
                <p class="mt-2 text-sm text-slate-500">A descrição, a data e a categoria escolhidas aqui não serão substituídas pela próxima sincronização.</p>

                <form method="POST" action="{{ route('pluggy.transactions.update', $transaction) }}" class="mt-8 space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="description">Descrição</label>
                        <input id="description" name="description" required maxlength="500" value="{{ old('description', $transaction->description) }}" class="mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="transaction_date">Data</label>
                        <input id="transaction_date" name="transaction_date" type="date" required value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" class="mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        @error('transaction_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="category_id">Categoria</label>
                        <select id="category_id" name="category_id" class="mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sem categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $transaction->category_id) === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('pluggy.transactions.show', $transaction) }}" class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancelar</a>
                        <button class="rounded-xl {{ $isIncome ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-rose-600 hover:bg-rose-700' }} px-5 py-3 text-sm font-medium text-white">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
