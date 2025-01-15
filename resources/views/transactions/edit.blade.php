@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ __('messages.edit_transaction') }}</h1>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="amount" class="form-label">{{ __('messages.amount') }}</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', $transaction->amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">{{ __('messages.type') }}</label>
            <select name="type" id="type" class="form-control" required>
                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>{{ __('messages.income') }}</option>
                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>{{ __('messages.expense') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">{{ __('messages.category') }}</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">{{ __('messages.date') }}</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $transaction->date) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.description') }}</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $transaction->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
