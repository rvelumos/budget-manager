@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.expenses') }}</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary">{{ __('messages.add_expense') }}</a>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.amount') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->category->name }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('expenses.show', $expense) }}" class="btn btn-info">{{ __('messages.view') }}</a>
                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
