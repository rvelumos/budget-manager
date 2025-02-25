@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.budget_title') }}</h1>
    <div class="container-btn-group">
        <a href="{{ route('budgets.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">{{ __('messages.create_budget') }}</a>
    </div>
    <div class="container mx-auto">

        @if ($budgets->isEmpty())
            <p>{{ __('messages.no_budgets') }}</p>
        @else
            <table class="w-full border-collapse border border-gray-300" style="border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">{{ __('messages.amount') }}</th>
                        <th class="border border-gray-300 p-2">{{ __('messages.category') }}</th>
                        <th class="border border-gray-300 p-2">{{ __('messages.period') }}</th>
                        <th class="border border-gray-300 p-2">{{ __('messages.start_date') }}</th>
                        <th class="border border-gray-300 p-2">{{ __('messages.end_date') }}</th>
                        <th class="border border-gray-300 p-2">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgets as $budget)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $budget->amount }}</td>
                            <td class="border border-gray-300 p-2">{{ $budget->category->name ?? 'None' }}</td>
                            <td class="border border-gray-300 p-2">{{ ucfirst($budget->period) }}</td>
                            <td class="border border-gray-300 p-2">{{ $budget->start_date }}</td>
                            <td class="border border-gray-300 p-2">{{ $budget->end_date ?? 'N/A' }}</td>
                            <td class="border border-gray-300 p-2">
                                <a href="{{ route('budgets.show', $budget) }}" class="text-blue-500">{{ __('messages.view') }}</a> |
                                <a href="{{ route('budgets.edit', $budget) }}" class="text-yellow-500">{{ __('messages.edit') }}</a> |
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">{{ __('messages.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
