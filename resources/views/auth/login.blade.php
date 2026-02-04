@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
            Entrar no sistema
        </h1>

        <form class="space-y-4" method="POST" action="{{ route('authenticate') }}">
            @csrf
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

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                Entrar
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">
            Não tem conta?
            <a href="{{ route('register.index') }}" class="text-indigo-600 hover:underline">
                Criar agora
            </a>
        </p>
    </div>
@endsection
