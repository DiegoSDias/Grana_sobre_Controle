<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-light text-slate-900">Categorias</h1>
                        <p class="text-slate-500 text-sm">Gerencie suas categorias de receitas e despesas</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('category-groups.index') }}" 
                       class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Gerenciar Grupos
                    </a>
                    
                    <a href="{{ route('categories.create') }}" 
                       class="group px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nova Categoria
                    </a>
                </div>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6 animate-slide-up">
            <form method="GET" class="flex flex-wrap gap-4 items-end">

                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-slate-700 to-slate-600 text-white rounded-xl font-medium hover:from-slate-800 hover:to-slate-700 transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtrar
                    </button>
                    
                    @if(request()->hasAny(['group_id', 'type']))
                        <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-medium hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Categorias por Tipo --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Receitas --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
                <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-6 border-b border-emerald-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-light text-emerald-900">Receitas</h2>
                            <p class="text-sm text-emerald-700/70">{{ $categoriesIncome->count() }} categorias</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                    @forelse($categoriesIncome as $category)
                        <div class="p-4 hover:bg-emerald-50/30 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium text-slate-900">{{ $category->name }}</h3>
                                    @if($category->group)
                                        <p class="text-xs text-slate-500 mt-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            {{ $category->group->name }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" 
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" 
                                                title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-400 text-sm">Nenhuma categoria de receita</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Despesas --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
                <div class="bg-gradient-to-r from-rose-50 to-red-50 p-6 border-b border-rose-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-light text-rose-900">Despesas</h2>
                            <p class="text-sm text-rose-700/70">{{ $categoriesExpense->count() }} categorias</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                    @forelse($categoriesExpense as $category)
                        <div class="p-4 hover:bg-rose-50/30 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium text-slate-900">{{ $category->name }}</h3>
                                    @if($category->group)
                                        <p class="text-xs text-slate-500 mt-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            {{ $category->group->name }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" 
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" 
                                                title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-400 text-sm">Nenhuma categoria de despesa</p>
                        </div>
                    @endforelse
                </div>
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
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    .animate-slide-up { animation: slide-up 0.8s ease-out backwards; }
</style>
</x-app-layout>