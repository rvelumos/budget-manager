@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <h1>{{ __('messages.income_listing_details') }}</h1>
    <div class="container-btn-group">
        <a href="{{ route('incomes.create', $incomeListing->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">{{ __('messages.add_income') }}</a>
    </div>
    <div class="container">

        <div class="card">
            <div class="card-header">
                {{ $incomeListing->name }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('messages.total_income') }}: </strong> {{ $incomeListing->incomes->sum('amount') }}</p>

                <button type="submit" class="btn btn-primary">
                    <a href="{{ route('income-listings.edit', $incomeListing->id) }}" class="btn btn-warning">{{ __('messages.edit_listing') }}</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
