@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.income_details') }}</h1>

    <div class="card">
        <div class="card-header">
            {{ __('messages.income_details') }}
        </div>
        <div class="card-body">
            <p><strong>{{ __('messages.category') }}: </strong> {{ $income->category->name }}</p>
            <p><strong>{{ __('messages.amount') }}: </strong> {{ $income->amount }}</p>
            <p><strong>{{ __('messages.date') }}: </strong> {{ $income->date }}</p>
            <p><strong>{{ __('messages.description') }}: </strong> {{ $income->description ?? __('messages.no_description') }}</p>
        </div>
    </div>

    <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning mt-3">{{ __('messages.edit_income') }}</a>
    <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">{{ __('messages.delete') }}</button>
    </form>
</div>
@endsection
