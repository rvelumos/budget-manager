@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.edit_budget') }}</h1>

    @include('budgets.form', [
        'action' => route('budgets.update', $budget),
        'method' => 'PUT',
        'budgets' => $budget,
        'categories' => $categories,
        'buttonText' => __('messages.edit_budget'),
    ])
</div>
@endsection
