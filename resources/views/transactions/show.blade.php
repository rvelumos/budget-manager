@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ __('messages.show_transaction') }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('messages.amount') }}: {{ number_format($transaction->amount, 2) }}</h5>
            <p class="card-text">{{ __('messages.type') }}: {{ ucfirst($transaction->type) }}</p>
            <p class="card-text">{{ __('messages.category') }}: {{ $transaction->category->name }}</p>
            <p class="card-text">{{ __('messages.date') }}: {{ $transaction->date }}</p>
            <p class="card-text">{{ __('messages.description') }}: {{ $transaction->description }}</p>
        </div>
    </div>

    <a href="{{ route('transactions.index') }}" class="btn btn-secondary mt-3">{{ __('messages.back_to_list') }}</a>
</div>
@endsection
