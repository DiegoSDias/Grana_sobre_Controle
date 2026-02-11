<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8 animate-fade-in">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-light text-slate-900">Perfil</h1>
                        <p class="text-slate-500 text-sm">Gerencie suas informações pessoais</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Informações do Perfil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-light text-blue-900">Informações do Perfil</h2>
                                <p class="text-sm text-blue-700/70">Atualize seu nome e endereço de e-mail</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Atualizar Senha --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 border-b border-amber-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-light text-amber-900">Atualizar Senha</h2>
                                <p class="text-sm text-amber-700/70">Use uma senha longa e segura para proteger sua conta</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Excluir Conta --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-slide-up" style="animation-delay: 0.3s">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 p-6 border-b border-red-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-light text-red-900">Excluir Conta</h2>
                                <p class="text-sm text-red-700/70">Exclua permanentemente sua conta e todos os dados</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        @include('profile.partials.delete-user-form')
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
                transform: translateY(30px);
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
            animation: slide-up 0.8s ease-out backwards;
        }
    </style>
</x-app-layout>