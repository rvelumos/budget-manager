@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.add_expense') }}</h1>
    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category">{{ __('messages.category') }}</label>
            <select name="category_id" id="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">{{ __('messages.amount') }}</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date">{{ __('messages.date') }}</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">{{ __('messages.create') }}</button>
    </form>
</div>
@endsection
