<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-light text-slate-900 mb-2">Criar conta</h2>
        <p class="text-slate-500">Preencha seus dados para começar</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6 animate-slide-up">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                Nome completo
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="João Silva"
                    required 
                    autofocus 
                    autocomplete="name"
                />
            </div>
            @if($errors->get('name'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('name') }}
                </p>
            @endif
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                E-mail
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </span>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="seu@email.com"
                    required 
                    autocomplete="username"
                />
            </div>
            @if($errors->get('email'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                Senha
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input 
                    id="password" 
                    type="password" 
                    name="password"
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="••••••••"
                    required 
                    autocomplete="new-password"
                />
            </div>
            @if($errors->get('password'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('password') }}
                </p>
            @else
                <p class="mt-1.5 text-xs text-slate-500">
                    Use no mínimo 8 caracteres com letras, números e símbolos
                </p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                Confirmar senha
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation"
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="••••••••"
                    required 
                    autocomplete="new-password"
                />
            </div>
            @if($errors->get('password_confirmation'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full group px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold hover:from-emerald-700 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
        >
            <span>Criar conta</span>
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-slate-200">
            <p class="text-sm text-slate-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors ml-1">
                    Faça login
                </a>
            </p>
        </div>
    </form>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }
    </style>
</x-guest-layout>