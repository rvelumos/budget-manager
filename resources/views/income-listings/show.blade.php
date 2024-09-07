@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.income_listing_details') }}</h1>

    <div class="card">
        <div class="card-header">
            {{ $incomeListing->name }}
        </div>
        <div class="card-body">
            <p><strong>{{ __('messages.description') }}: </strong> {{ $incomeListing->description ?? __('messages.no_description') }}</p>
            <p><strong>{{ __('messages.total_income') }}: </strong> {{ $incomeListing->incomes->sum('amount') }}</p>

            <a href="{{ route('incomelistings.edit', $incomeListing->id) }}" class="btn btn-warning">{{ __('messages.edit_listing') }}</a>
        </div>
    </div>
</div>
@endsection
