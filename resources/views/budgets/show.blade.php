@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Budget Details</h1>

    <div class="mb-4">
        <strong>Amount:</strong> {{ $budget->amount }}
    </div>
    <div class="mb-4">
        <strong>Category:</strong> {{ $budget->category->name ?? 'None' }}
    </div>
    <div class="mb-4">
        <strong>Period:</strong> {{ ucfirst($budget->period) }}
    </div>
    <div class="mb-4">
        <strong>Start Date:</strong> {{ $budget->start_date }}
    </div>
    <div class="mb-4">
        <strong>End Date:</strong> {{ $budget->end_date ?? 'N/A' }}
    </div>

    <a href="{{ route('budgets.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded">Back to Budgets</a>
</div>
@endsection
