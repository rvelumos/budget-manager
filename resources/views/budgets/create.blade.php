@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.create_budget') }}</h1>
    <div class="container mx-auto">

        @include('budgets.form', [
            'action' => route('budgets.store'),
            'method' => null,
            'budgets' => null,
            'categories' => $categories,
            'buttonText' => __('messages.create_budget'),
        ])
    </div>
</div>
@endsection
