@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <h1 class="text-2xl font-bold mb-6">Budgets</h1>
    <div class="container-btn-group">
        <a href="{{ route('budgets.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">Create New Budget</a>
    </div>
    <div class="container mx-auto">

        @if ($budgets->isEmpty())
            <p>No budgets found.</p>
        @else
            <table class="w-full border-collapse border border-gray-300" style="border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Amount</th>
                        <th class="border border-gray-300 p-2">Category</th>
                        <th class="border border-gray-300 p-2">Period</th>
                        <th class="border border-gray-300 p-2">Start Date</th>
                        <th class="border border-gray-300 p-2">End Date</th>
                        <th class="border border-gray-300 p-2">Actions</th>
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
                                <a href="{{ route('budgets.show', $budget) }}" class="text-blue-500">View</a> |
                                <a href="{{ route('budgets.edit', $budget) }}" class="text-yellow-500">Edit</a> |
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
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
