@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

        @if ($type == 'income')
            <h1 class="text-xl font-bold mb-6">Nova Renda</h1>
        @else
            <h1 class="text-xl font-bold mb-6">Nova Despesa</h1>
        @endif

        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf

            @include('expenses._form')

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ url()->previous() }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                    Cancelar
                </a>

                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                    Salvar despesa
                </button>
            </div>
        </form>

    </div>

    <script>
        const categorySelect = document.getElementById('categorySelect')
        const newCategoryField = document.getElementById('newCategoryField')
        const installmentRadios = document.querySelectorAll('input[name="is_installment"]')
        const installmentsField = document.getElementById('installmentsField')

        categorySelect.addEventListener('change', function() {
            if (this.value === 'new') {
                newCategoryField.classList.remove('hidden')
            } else {
                newCategoryField.classList.add('hidden')
            }
        })

        installmentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === '1') {
                    installmentsField.classList.remove('hidden')
                } else {
                    installmentsField.classList.add('hidden')
                }
            })
        })
    </script>
@endsection
