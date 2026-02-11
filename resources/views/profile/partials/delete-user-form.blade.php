<section class="space-y-6">
    <div class="bg-red-50 border border-red-200 rounded-xl p-5">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-red-900 mb-1">Atenção: Ação Irreversível</h3>
                <p class="text-sm text-red-800">
                    Uma vez excluída, sua conta e todos os dados associados serão removidos permanentemente. 
                    Antes de prosseguir, certifique-se de fazer backup de qualquer informação importante.
                </p>
            </div>
        </div>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        type="button"
        class="group px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-medium hover:from-red-700 hover:to-rose-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2"
    >
        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Excluir Conta
    </button>

    {{-- Modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">
                        Tem certeza que deseja excluir sua conta?
                    </h2>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-red-800">
                    Esta ação não pode ser desfeita. Todos os seus dados, incluindo receitas, despesas e categorias, 
                    serão permanentemente removidos. Por favor, digite sua senha para confirmar.
                </p>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Confirme sua senha
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all shadow-sm"
                            placeholder="Digite sua senha"
                            required
                        />
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    @if($errors->userDeletion->get('password'))
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $errors->userDeletion->first('password') }}
                        </p>
                    @endif
                </div>

                <div class="flex justify-end gap-3">
                    <button 
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-6 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm"
                    >
                        Cancelar
                    </button>

                    <button 
                        type="submit"
                        class="group px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-medium hover:from-red-700 hover:to-rose-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2"
                    >
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Excluir Conta
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>