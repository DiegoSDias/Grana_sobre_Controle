@php
    $selected = isset($group)
        ? $group->categories->map(fn($cat) => [
            'id' => (string) $cat->id,
            'type' => $cat->type
        ])->values()
        : collect();
@endphp

<div
    x-data="{
        incomeCategories: {{ json_encode($selected->where('type','income')->pluck('id')->values()) }},
        expenseCategories: {{ json_encode($selected->where('type','expense')->pluck('id')->values()) }},

        addIncome() { this.incomeCategories.push('') },
        removeIncome(index) { this.incomeCategories.splice(index,1) },

        addExpense() { this.expenseCategories.push('') },
        removeExpense(index) { this.expenseCategories.splice(index,1) }
    }"
    class="space-y-10"
>

    {{-- ================= NOME DO GRUPO ================= --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Nome do Grupo
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $group->name ?? '') }}"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl
                   text-slate-900 focus:ring-2 focus:ring-purple-500
                   focus:border-purple-500 transition-all shadow-sm"
            placeholder="Ex: Fixas, Variáveis, Lazer..."
            required
        />
    </div>

    <div class="border-t border-slate-200"></div>

    {{-- ================= CATEGORIAS DE RENDA ================= --}}
    <div class="space-y-4">

        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-emerald-700">
                    Categorias de Renda
                </h3>
                <p class="text-xs text-slate-500">Entradas de dinheiro</p>
            </div>

            <button
                type="button"
                @click="addIncome()"
                class="px-4 py-2 rounded-xl
                       bg-gradient-to-r from-emerald-500 to-green-600
                       text-white text-sm shadow-sm hover:shadow-md"
            >
                + Adicionar Renda
            </button>
        </div>

        <template x-for="(categoryId, index) in incomeCategories" :key="'income-'+index">
            <div class="p-4 bg-white border-2 border-emerald-200 rounded-xl">

                <div class="flex gap-4">

                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Categoria
                        </label>

                        <select
                            name="income_categories[]"
                            x-model="incomeCategories[index]"
                            class="w-full px-4 py-3 bg-white border border-slate-200
                                   rounded-xl focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="">Selecione</option>

                            @foreach($incomeCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            type="button"
                            @click="removeIncome(index)"
                            class="p-2 rounded-lg text-red-600 hover:bg-red-50"
                        >
                            Remover
                        </button>
                    </div>

                </div>
            </div>
        </template>

        <div
            x-show="incomeCategories.length === 0"
            class="p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-center"
        >
            <p class="text-slate-400 text-sm">
                Nenhuma categoria de renda adicionada
            </p>
        </div>

    </div>

    {{-- ================= CATEGORIAS DE DESPESA ================= --}}
    <div class="space-y-4">

        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-rose-700">
                    Categorias de Despesa
                </h3>
                <p class="text-xs text-slate-500">Saídas de dinheiro</p>
            </div>

            <button
                type="button"
                @click="addExpense()"
                class="px-4 py-2 rounded-xl
                       bg-gradient-to-r from-rose-500 to-red-600
                       text-white text-sm shadow-sm hover:shadow-md"
            >
                + Adicionar Despesa
            </button>
        </div>

        <template x-for="(categoryId, index) in expenseCategories" :key="'expense-'+index">
            <div class="p-4 bg-white border-2 border-rose-200 rounded-xl">

                <div class="flex gap-4">

                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Categoria
                        </label>

                        <select
                            name="expense_categories[]"
                            x-model="expenseCategories[index]"
                            class="w-full px-4 py-3 bg-white border border-slate-200
                                   rounded-xl focus:ring-2 focus:ring-rose-500"
                        >
                            <option value="">Selecione</option>

                            @foreach($expenseCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            type="button"
                            @click="removeExpense(index)"
                            class="p-2 rounded-lg text-red-600 hover:bg-red-50"
                        >
                            Remover
                        </button>
                    </div>

                </div>
            </div>
        </template>

        <div
            x-show="expenseCategories.length === 0"
            class="p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-center"
        >
            <p class="text-slate-400 text-sm">
                Nenhuma categoria de despesa adicionada
            </p>
        </div>

    </div>

</div>



<script>
function categoryManager(allCategories, initialSelected = []) {
    return {
        allCategories: allCategories,
        selectedCategories: initialSelected.length ? initialSelected : [],

        init() {
            // força reatividade no Alpine
            this.selectedCategories = [...this.selectedCategories]
        },

        addCategory() {
            this.selectedCategories.push('');
        },

        removeCategory(index) {
            this.selectedCategories.splice(index, 1);
        }
    }
}
</script>
