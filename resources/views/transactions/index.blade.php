@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.transactions') }}</h1>

    <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions"
                type="button" role="tab" aria-controls="transactions" aria-selected="true">
                {{ __('messages.transactions') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="recurring-transactions-tab" data-bs-toggle="tab"
                data-bs-target="#recurring-transactions" type="button" role="tab"
                aria-controls="recurring-transactions" aria-selected="false">
                {{ __('messages.recurring_transactions') }}
            </button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="transactionTabsContent">
        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">
                {{ __('messages.add_transaction') }}
            </a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('messages.amount') }}</th>
                        <th>{{ __('messages.category') }}</th>
                        <th>{{ __('messages.date') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td>{{ $transaction->date }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="recurring-transactions" role="tabpanel" aria-labelledby="recurring-transactions-tab">
            <a href="{{ route('recurring-transactions.create') }}" class="btn btn-primary mb-3">
                {{ __('messages.add_recurring_transaction') }}
            </a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('messages.amount') }}</th>
                        <th>{{ __('messages.category') }}</th>
                        <th>{{ __('messages.start_date') }}</th>
                        <th>{{ __('messages.frequency') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recurringTransactions as $recurringTransaction)
                    <tr>
                        <td>{{ $recurringTransaction->amount }}</td>
                        <td>{{ $recurringTransaction->category->name }}</td>
                        <td>{{ $recurringTransaction->start_date }}</td>
                        <td>{{ $recurringTransaction->frequency }}</td>
                        <td>
                            <a href="{{ route('recurring-transactions.edit', $recurringTransaction->id) }}"
                                class="btn btn-warning btn-sm">
                                {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('recurring-transactions.destroy', $recurringTransaction->id) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
