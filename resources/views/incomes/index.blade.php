@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('messages.incomes') }}</h1>
    <a href="{{ route('incomes.create') }}" class="btn btn-primary mb-3">{{ __('messages.add_new_income') }}</a>

    @if($incomes->count())
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
                @foreach ($incomes as $income)
                    <tr>
                        <td>{{ $income->category->name }}</td>
                        <td>{{ $income->amount }}</td>
                        <td>{{ $income->date }}</td>
                        <td>
                            <a href="{{ route('incomes.show', $income->id) }}" class="btn btn-info">{{ __('messages.income_details') }}</a>
                            <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning">{{ __('messages.edit_income') }}</a>
                            <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>{{ __('messages.no_incomes_found') }}</p>
    @endif
</div>
@endsection
