<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Senha Atual --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-2">
                Senha Atual
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all shadow-sm hover:border-slate-300" 
                    autocomplete="current-password"
                    placeholder="Digite sua senha atual"
                />
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        {{-- Nova Senha --}}
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-2">
                Nova Senha
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all shadow-sm hover:border-slate-300" 
                    autocomplete="new-password"
                    placeholder="Digite uma nova senha"
                />
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            @if($errors->updatePassword->get('password'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @else
                <p class="mt-1.5 text-xs text-slate-500">
                    Use no mínimo 8 caracteres com letras, números e símbolos
                </p>
            @endif
        </div>

        {{-- Confirmar Senha --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                Confirmar Nova Senha
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all shadow-sm hover:border-slate-300" 
                    autocomplete="new-password"
                    placeholder="Confirme a nova senha"
                />
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
            @endif
        </div>

        {{-- Botões --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="group px-6 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 text-white font-medium hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Atualizar Senha
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-medium flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Senha atualizada com sucesso!
                </p>
            @endif
        </div>
    </form>
</section>