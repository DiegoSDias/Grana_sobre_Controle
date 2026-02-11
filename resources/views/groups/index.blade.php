<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-light text-slate-900">Grupos de Categorias</h1>
                        <p class="text-slate-500 text-sm">Organize suas categorias em grupos</p>
                    </div>
                </div>

                <a href="{{ route('category-groups.create') }}" 
                   class="group px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Novo Grupo
                </a>
            </div>
        </div>

        {{-- Lista de Grupos --}}
        @if($groups->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center animate-slide-up">
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-slate-50 flex items-center justify-center">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <p class="text-slate-500 font-medium text-lg mb-1">Nenhum grupo criado</p>
                <p class="text-slate-400 text-sm">Crie seu primeiro grupo de categorias</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($groups as $group)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all duration-200 animate-scale-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        {{-- Header do Card --}}
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 p-5 border-b border-slate-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $group->name }}</h3>
                                    <p class="text-xs text-slate-500">
                                        {{ $group->categories->count() }} {{ $group->categories->count() === 1 ? 'categoria' : 'categorias' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('category-groups.edit', $group) }}" 
                                       class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" 
                                       title="Editar grupo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('category-groups.destroy', $group) }}" method="POST" 
                                          onsubmit="return confirm('Tem certeza? Todas as categorias deste grupo serão desvinculadas.')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors" 
                                                title="Excluir grupo">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Categorias do Grupo --}}
                        <div class="p-5">
                            @if($group->categories->isEmpty())
                                <p class="text-sm text-slate-400 italic text-center py-4">
                                    Nenhuma categoria neste grupo
                                </p>
                            @else
                                <div class="space-y-2">
                                    @foreach($group->categories->take(5) as $category)
                                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full {{ $category->type === 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                                <span class="text-sm font-medium text-slate-700">{{ $category->name }}</span>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-md {{ $category->type === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ $category->type === 'income' ? 'Receita' : 'Despesa' }}
                                            </span>
                                        </div>
                                    @endforeach
                                    
                                    @if($group->categories->count() > 5)
                                        <p class="text-xs text-slate-400 text-center pt-2">
                                            + {{ $group->categories->count() - 5 }} categorias
                                        </p>
                                    @endif
                                </div>
                            @endif

                            <a href="{{ route('category-groups.show', $group) }}" 
                               class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

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

    @keyframes scale-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    .animate-slide-up { animation: slide-up 0.8s ease-out backwards; }
    .animate-scale-in { animation: scale-in 0.4s ease-out backwards; }
</style>

</x-app-layout>