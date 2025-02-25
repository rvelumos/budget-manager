@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.budget_details') }}</h1>
    <div class="container mx-auto">

        <div class="mb-4">
            <strong>{{ __('messages.amount') }}</strong> {{ $budget->amount }}
        </div>
        <div class="mb-4">
            <strong>{{ __('messages.category') }}</strong> {{ $budget->category->name ?? 'None' }}
        </div>
        <div class="mb-4">
            <strong>{{ __('messages.period') }}</strong> {{ ucfirst($budget->period) }}
        </div>
        <div class="mb-4">
            <strong>{{ __('messages.start_date') }}</strong> {{ $budget->start_date }}
        </div>
        <div class="mb-4">
            <strong>{{ __('messages.end_date') }}</strong> {{ $budget->end_date ?? 'N/A' }}
        </div>

        <a href="{{ route('budgets.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded">{{ __('messages.back') }}</a>
    </div>
</div>
@endsection
