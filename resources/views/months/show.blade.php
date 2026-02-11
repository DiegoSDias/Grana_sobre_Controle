<x-app-layout>

    @if ($expenses->isEmpty())
        @include('months.empty')
    @else
        @include('expenses.index')
    @endif
</x-app-layout>
