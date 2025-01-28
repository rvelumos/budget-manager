@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('forecasts.details.title') }}</h1>

        <div class="mb-4">
            <strong>{{ __('forecasts.details.month') }}:</strong>
            {{ $forecast->month->format('F Y') }}
        </div>

        <div class="mb-4">
            <strong>{{ __('forecasts.details.expected_income') }}:</strong> {{ number_format($forecast->expected_income, 2) }}
        </div>

        <div class="mb-4">
            <strong>{{ __('forecasts.details.expected_expenses') }}:</strong> {{ number_format($forecast->expected_expenses, 2) }}
        </div>

        <div class="mb-4">
            <strong>{{ __('forecasts.details.net_forecast') }}:</strong> {{ number_format($forecast->net_forecast, 2) }}
        </div>

        <div class="mb-4">
            <strong>{{ __('forecasts.details.accuracy_rate') }}:</strong>
            {{ $forecast->accuracy_rate ?? __('forecasts.details.not_available') }}%
        </div>

        <a href="{{ route('forecasts.index') }}" class="btn btn-secondary">
            {{ __('forecasts.actions.back_to_list') }}
        </a>
    </div>
@endsection
