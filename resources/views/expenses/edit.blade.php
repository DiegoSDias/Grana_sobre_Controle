@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-6">
        Editar {{ $expense->type === 'income' ? 'Renda' : 'Despesa' }}
    </h1>

    <form action="{{ route('expenses.update', $expense) }}" method="POST">
        @csrf
        @method('PUT')

        @include('expenses._form', [
            'expense' => $expense,
            'type' => $expense->type
        ])

        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ url()->previous() }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                Cancelar
            </a>

            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Atualizar
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
