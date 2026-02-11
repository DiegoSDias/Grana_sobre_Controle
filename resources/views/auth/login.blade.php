<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-light text-slate-900 mb-2">Bem-vindo de volta</h2>
        <p class="text-slate-500">Entre com sua conta para continuar</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl animate-slide-up">
            <p class="text-sm text-emerald-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('status') }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-slide-up">
        @csrf

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
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="seu@email.com"
                    required 
                    autofocus 
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
                    class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm hover:border-slate-300" 
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password"
                />
            </div>
            @if($errors->get('password'))
                <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all cursor-pointer"
                />
                <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">
                    Lembrar de mim
                </span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full group px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
        >
            <span>Entrar</span>
            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-slate-200">
            <p class="text-sm text-slate-600">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors ml-1">
                    Cadastre-se
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