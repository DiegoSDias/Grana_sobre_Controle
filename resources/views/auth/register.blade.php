@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
            Criar conta
        </h1>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Nome
                </label>
                <input type="text"
                    name="name"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Seu nome">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    E-mail
                </label>
                <input type="email"
                    name="email"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="seu@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Senha
                </label>
                <input type="password"
                    name="password"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="••••••••">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Confirmar senha
                </label>
                <input type="password"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                Criar conta
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">
            Já tem conta?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                Entrar
            </a>
        </p>
    </div>
@endsection
