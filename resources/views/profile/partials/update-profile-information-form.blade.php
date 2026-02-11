<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Nome --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                Nome
                <span class="text-red-500">*</span>
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
            />
            @if($errors->get('name'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('name') }}
                </p>
            @endif
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                E-mail
                <span class="text-red-500">*</span>
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
            />
            @if($errors->get('email'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('email') }}
                </p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl">
                    <p class="text-sm text-amber-800 mb-2">
                        Seu endereço de e-mail não está verificado.
                    </p>
                    <button form="send-verification" class="text-sm text-amber-700 hover:text-amber-900 font-medium underline transition-colors">
                        Clique aqui para reenviar o e-mail de verificação
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-emerald-700 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Um novo link de verificação foi enviado para seu e-mail
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Botões --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="group px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Salvar
            </button>

            @if (session('status') === 'profile-updated')
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
                    Salvo com sucesso!
                </p>
            @endif
        </div>
    </form>
</section>