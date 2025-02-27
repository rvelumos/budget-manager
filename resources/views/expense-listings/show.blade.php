@extends('layouts.app')

@section('content')

    <div class="content-wrapper">
        <h1>{{ __('messages.expense_listing_details') }}</h1>
        <div class="container-btn-group">
            <a href="{{ route('expenses.create', $expenseListing->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">{{ __('messages.add_expense') }}</a>
        </div>
        <div class="container">

            <div class="card">
                <div class="card-header">
                    {{ $expenseListing->name }}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('messages.total_expense') }}: </strong> {{ $expenseListing->expenses->sum('amount') }}</p>

                    <button type="submit" class="btn btn-primary">
                        <a href="{{ route('expense-listings.edit', $expenseListing->id) }}" class="btn btn-warning">{{ __('messages.edit_listing') }}</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
