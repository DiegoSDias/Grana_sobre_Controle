{{-- Descrição --}}
<div class="mb-4">
    <label class="block mb-1">Descrição</label>
    <input
        type="text"
        name="description"
        class="input w-full"
        value="{{ old('description', $expense->description ?? '') }}"
    >
</div>

{{-- Valor --}}
<div class="mb-4">
    <label class="block mb-1">Valor</label>
    <input
        type="number"
        step="0.01"
        name="amount"
        class="input w-full"
        value="{{ old('amount', $expense->amount ?? '') }}"
        required
    >
</div>

{{-- Categoria --}}
<div class="mb-4">
    <label class="block mb-1">Categoria</label>

    <select name="category_id" id="categorySelect" class="input w-full">
        <option value="">Selecione</option>
        
        @foreach ($categories as $category)
            @if ($category->type == $type)  
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $expense->category_id ?? null) == $category->id)
                    >
                    {{ $category->name }}
                </option>
            @endif
        @endforeach

        <option value="new">+ Criar nova categoria</option>
    </select>
</div>

{{-- Nova categoria --}}
<div class="mb-4 hidden" id="newCategoryField">

        <label class="block mb-1">Nova categoria</label>
        <input
        type="text"
        name="new_category"
        class="input w-full"
        placeholder="Ex: Alimentação"
        value="{{ old('new_category') }}"
        >
</div>

{{-- Compra parcelada --}}
@if ($type == 'expense')

<div class="mb-4">
    <label class="block mb-2">Compra parcelada?</label>

    <label class="mr-4">
        <input
            type="radio"
            name="is_installment"
            value="0"
            checked
        >
        Não
    </label>

    <label>
        <input
            type="radio"
            name="is_installment"
            value="1"
            {{ old('is_installment', $expense->is_installment ?? false) ? 'checked' : '' }}
        >
        Sim
    </label>
</div>

{{-- Total de parcelas --}}
<div class="mb-4 hidden" id="installmentsField">
    <label class="block mb-1">Total de parcelas</label>
    <input
        type="number"
        min="2"
        name="total_installments"
        class="input w-full"
        value="{{ old('total_installments', $expense->total_installments ?? '') }}"
        placeholder="Ex: 10"
    >
</div>

@endif

{{-- Campos ocultos --}}
<input type="hidden" name="month" value="{{ $month }}">
<input type="hidden" name="year" value="{{ $year }}">
<input type="hidden" name="type" value="{{ $type }}">
