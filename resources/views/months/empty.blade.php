<div class="min-h-screen flex items-center justify-center bg-linear-to-br from-slate-50 to-slate-100">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        <a href="{{ route('expenses.create', ['type' => 'income', 'year' => $year, 'month' => $month]) }}"
            class="group w-72 h-72 rounded-2xl bg-linear-to-br from-green-400 to-green-600 flex flex-col items-center justify-center text-white shadow-xl hover:scale-105 hover:shadow-2xl transition-all">

            <span class="text-6xl mb-4">+</span>
            <h2 class="text-2xl font-bold">Adicionar Receita</h2>
            <p class="text-white/80 mt-2 text-sm">Salário, presente, extra</p>
        </a>

        <a href="{{ route('expenses.create', ['type' => 'expense', 'year' => $year, 'month' => $month]) }}"
            class="group w-72 h-72 rounded-2xl bg-linear-to-br from-red-400 to-red-600 flex flex-col items-center justify-center text-white shadow-xl hover:scale-105 hover:shadow-2xl transition-all">

            <span class="text-6xl mb-4">−</span>
            <h2 class="text-2xl font-bold">Adicionar Despesa</h2>
            <p class="text-white/80 mt-2 text-sm">Comida, aluguel, transporte</p>
        </a>

    </div>
</div>
