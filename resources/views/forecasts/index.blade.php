@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('forecasts.index.title') }}</h1>

        <div class="mb-6">
            <h2 class="text-xl font-semibold">{{ __('forecasts.summary.title') }}</h2>
            <p><strong>{{ __('forecasts.summary.total_income') }}:</strong> {{ number_format($forecasts->totalIncome, 2) }}</p>
            <p><strong>{{ __('forecasts.summary.total_expense') }}:</strong> {{ number_format($forecasts->totalExpense, 2) }}</p>
            <p><strong>{{ __('forecasts.summary.net_savings') }}:</strong> {{ number_format($forecasts->netSavings, 2) }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold">{{ __('forecasts.categories.title') }}</h2>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                <tr>
                    <th class="border border-gray-300 p-2">{{ __('forecasts.categories.category') }}</th>
                    <th class="border border-gray-300 p-2">{{ __('forecasts.categories.total_expenses') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($forecasts->expensesByCategory as $categoryExpense)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $categoryExpense->category->name }}</td>
                        <td class="border border-gray-300 p-2">{{ number_format($categoryExpense->total_amount, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
