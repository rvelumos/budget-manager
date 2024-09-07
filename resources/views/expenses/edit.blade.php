@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.edit_expense') }}</h1>
    <form action="{{ route('expenses.update', $expense) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category">{{ __('messages.category') }}</label>
            <select name="category_id" id="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id === $expense->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">{{ __('messages.amount') }}</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}" required>
        </div>
        <div class="form-group">
            <label for="date">{{ __('messages.date') }}</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $expense->date->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-warning">{{ __('messages.update') }}</button>
    </form>
</div>
@endsection
