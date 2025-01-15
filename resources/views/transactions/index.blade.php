@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ __('messages.transactions') }}</h1>

    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">{{ __('messages.add_transaction') }}</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{{ __('messages.amount') }}</th>
                <th>{{ __('messages.type') }}</th>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.description') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">{{ __('messages.view') }}</a>
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.are_you_sure') }}')">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('messages.no_transactions_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
