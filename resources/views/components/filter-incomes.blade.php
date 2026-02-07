{{-- RECEITAS - Formulário de Filtros --}}
<form method="GET" class="p-5 bg-slate-50 border-b border-slate-200">
    <div class="flex flex-wrap gap-3 items-end">
        
        {{-- Categoria --}}
        <div class="w-44">
            <label class="block text-xs font-medium text-slate-600 mb-1.5">Categoria</label>
            <select name="income_category"
                class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                <option value="">Todas</option>
                @foreach ($categoriesIncome as $income)
                    <option value="{{ $income->id }}" @selected(request('income_category') == $income->id)>
                        {{ $income->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filtro de Valor --}}
        <div class="flex gap-2">
            <div class="w-36">
                <label class="block text-xs font-medium text-slate-600 mb-1.5">Valor</label>
                <select name="income_value_op"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    <option value=">=" @selected(request('income_value_op') === '>=' || !request('income_value_op'))>Maior ou igual</option>
                    <option value="<=" @selected(request('income_value_op') === '<=')>Menor ou igual</option>
                    <option value="=" @selected(request('income_value_op') === '=')>Igual a</option>
                </select>
            </div>
            
            <div class="w-32">
                <label class="block text-xs font-medium text-slate-600 mb-1.5">&nbsp;</label>
                <input type="number" step="0.01" name="income_value" value="{{ request('income_value') }}"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                    placeholder="Ex: 1000">
            </div>
        </div>

        {{-- Botões --}}
        <button type="submit"
            class="px-5 py-2 bg-linear-to-r from-slate-700 to-slate-600 text-white rounded-lg text-sm font-medium hover:from-slate-800 hover:to-slate-700 transition-all shadow-sm hover:shadow-md flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filtrar
        </button>
        
        @if(request()->hasAny(['income_category', 'income_value_op', 'income_value']))
            <a href="{{ url()->current() }}"
                class="px-5 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Limpar
            </a>
        @endif
    </div>
</form>