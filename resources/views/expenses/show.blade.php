@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.expense_details') }}</h1>
    <p><strong>{{ __('messages.category') }}:</strong> {{ $expense->category->name }}</p>
    <p><strong>{{ __('messages.amount') }}:</strong> {{ $expense->amount }}</p>
    <p><strong>{{ __('messages.date') }}:</strong> {{ $expense->date->format('Y-m-d') }}</p>
    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
    </form>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">{{ __('messages.back_to_expenses') }}</a>
</div>
@endsection
