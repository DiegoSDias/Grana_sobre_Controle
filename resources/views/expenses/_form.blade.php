<div class="space-y-6">

    {{-- Descrição --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Descrição
            <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="description"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300"
            value="{{ old('description', $expense->description ?? '') }}"
            placeholder="Ex: Compra no supermercado"
        >
        @error('description')
            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Valor --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Valor
            <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">R$</span>
            <input
                type="number"
                step="0.01"
                name="amount"
                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300"
                value="{{ old('amount', $expense->amount ?? '') }}"
                placeholder="0,00"
                required
            >
        </div>
        @error('amount')
            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Categoria --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Categoria
        </label>
        <select 
            name="category_id" 
            id="categorySelect" 
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300 appearance-none cursor-pointer"
            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23475569%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;"
        >
            <option value="">Selecione uma categoria</option>
            
            @foreach ($categories as $category)
                @if ($category->type == $type)  
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id', $expense->category_id ?? null) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endif
            @endforeach

            <option value="new" class="font-semibold text-blue-600">+ Criar nova categoria</option>
        </select>
        @error('category_id')
            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Nova categoria --}}
    <div class="hidden" id="newCategoryField">
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Nova categoria
            <span class="text-red-500">*</span>
        </label>
        <div class="flex gap-2">
            <input
                type="text"
                name="new_category"
                class="flex-1 px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                placeholder="Ex: Alimentação"
                value="{{ old('new_category') }}"
            >
            <button 
                type="button" 
                onclick="document.getElementById('categorySelect').value = ''; document.getElementById('newCategoryField').classList.add('hidden');"
                class="px-4 py-3 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors"
                title="Cancelar"
            >
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <p class="mt-1.5 text-xs text-blue-600">Digite o nome da nova categoria e ela será criada automaticamente</p>
    </div>

    @if ($type == 'expense')
        {{-- Modo de Pagamento --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-3">
                Modo de Pagamento
            </label>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative flex items-center px-4 py-3 bg-white border-2 border-slate-200 rounded-xl cursor-pointer hover:border-purple-300 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 transition-all group">
                    <input
                        type="radio"
                        name="payment_mode"
                        value="pix"
                        class="sr-only"
                        {{ old('payment_mode', $expense->payment_mode ?? 'pix') === 'pix' ? 'checked' : '' }}
                    >
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 group-has-[:checked]:border-purple-500 group-has-[:checked]:bg-purple-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-purple-700">Pix</span>
                    </div>
                </label>

                <label class="relative flex items-center px-4 py-3 bg-white border-2 border-slate-200 rounded-xl cursor-pointer hover:border-amber-300 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 transition-all group">
                    <input
                        type="radio"
                        name="payment_mode"
                        value="cartao"
                        class="sr-only"
                        {{ old('payment_mode', $expense->payment_mode ?? '') === 'cartao' ? 'checked' : '' }}
                    >
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 group-has-[:checked]:border-amber-500 group-has-[:checked]:bg-amber-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-amber-700">Cartão</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Compra parcelada --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-3">
                Compra parcelada?
            </label>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative flex items-center px-4 py-3 bg-white border-2 border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 has-[:checked]:border-slate-500 has-[:checked]:bg-slate-50 transition-all group">
                    <input
                        type="radio"
                        name="is_installment"
                        value="0"
                        class="sr-only"
                        {{ old('is_installment', $expense->is_installment ?? '0') == '0' ? 'checked' : '' }}
                    >
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 group-has-[:checked]:border-slate-500 group-has-[:checked]:bg-slate-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-slate-900">Não</span>
                    </div>
                </label>

                <label class="relative flex items-center px-4 py-3 bg-white border-2 border-slate-200 rounded-xl cursor-pointer hover:border-blue-300 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all group">
                    <input
                        type="radio"
                        name="is_installment"
                        value="1"
                        class="sr-only"
                        {{ old('is_installment', $expense->is_installment ?? '0') == '1' ? 'checked' : '' }}
                    >
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 group-has-[:checked]:border-blue-500 group-has-[:checked]:bg-blue-500 flex items-center justify-center transition-all">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 group-has-[:checked]:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-blue-700">Sim</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Total de parcelas --}}
        <div id="installmentsField" class="hidden" >
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Total de parcelas
                <span class="text-red-500">*</span>
            </label>
            <input
                type="number"
                min="2"
                name="total_installments"
                class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                value="{{ old('total_installments', $expense->total_installments ?? '') }}"
                placeholder="Ex: 10"
            >
            <p class="mt-1.5 text-xs text-blue-600">Número mínimo de parcelas: 2</p>
        </div>
    @endif

    {{-- Campos ocultos --}}
    <input type="hidden" name="month" value="{{ $month }}">
    <input type="hidden" name="year" value="{{ $year }}">
    <input type="hidden" name="type" value="{{ $type }}">

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const installmentRadios = document.querySelectorAll('input[name="is_installment"]');
        const installmentsField = document.getElementById('installmentsField');

        function toggleInstallmentsField() {
            const selected = document.querySelector('input[name="is_installment"]:checked');
            
            if (selected && selected.value === '1') {
                installmentsField.classList.remove('hidden');
            } else {
                installmentsField.classList.add('hidden');
            }
        }

        // Verifica ao carregar a página
        toggleInstallmentsField();

        // Escuta mudança
        installmentRadios.forEach(radio => {
            radio.addEventListener('change', toggleInstallmentsField);
        });
    });
</script>