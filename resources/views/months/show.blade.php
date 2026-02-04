@extends('layouts.app')

@section('content')
    @if ($expenses->isEmpty())
        @include('months.empty')
    @else
        @include('expenses.index')
    @endif
@endsection
