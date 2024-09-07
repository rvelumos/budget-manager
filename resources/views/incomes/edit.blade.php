@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.edit_income') }}</h1>

    <form action="{{ route('incomes.update', $income->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="category_id" class="form-label">{{ __('messages.category') }}</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $income->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('messages.amount') }}</label>
            <input type="number" step="0.01" class="form-control" name="amount" value="{{ $income->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('messages.date') }}</label>
            <input type="date" class="form-control" name="date" value="{{ $income->date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.update_income') }}</button>
    </form>
</div>
@endsection
