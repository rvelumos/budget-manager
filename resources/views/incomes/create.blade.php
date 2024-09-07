@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.add_income') }}</h1>

    <form action="{{ route('incomes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category_id" class="form-label">{{ __('messages.category') }}</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('messages.amount') }}</label>
            <input type="number" step="0.01" class="form-control" name="amount" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('messages.date') }}</label>
            <input type="date" class="form-control" name="date" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save_income') }}</button>
    </form>
</div>
@endsection
