@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <h1>{{ __('Transactions') }}</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Category/Frequency') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($allTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->type === 'recurring' ? $transaction->start_date : $transaction->date }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>
                            @if ($transaction->type === 'recurring')
                                {{ ucfirst($transaction->frequency) }}
                            @endif
                        </td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>
                            <!-- Corrected route generation for edit -->
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a>

                            <!-- Corrected route generation for destroy -->
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">{{ __('No transactions found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
