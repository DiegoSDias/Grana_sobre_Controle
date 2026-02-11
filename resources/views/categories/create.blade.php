<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-3xl mx-auto px-4">
        
        <div class="mb-6 animate-fade-in">
            <a href="{{ route('categories.index') }}" 
               class="group inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors mb-4">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Voltar</span>
            </a>

            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-light text-slate-900">Nova Categoria</h1>
                    <p class="text-slate-500 text-sm">Crie uma categoria para organizar suas transações</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 animate-slide-up">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                @include('categories._form')

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
                    <a href="{{ route('categories.index') }}" 
                       class="px-6 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm hover:shadow-md">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="group px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Criar Categoria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slide-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.6s ease-out; }
    .animate-slide-up { animation: slide-up 0.8s ease-out; }
</style>

</x-app-layout>