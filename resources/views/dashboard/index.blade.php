@extends('layouts.app')

@section('content')

    <div class="dashboard-container">
        <header>
            <h1>{{ __('dashboard.title') }}</h1>
            <p>{{ __('dashboard.subtitle') }}</p>
        </header>

        <section class="summary">
            <div class="card">
                <h2>{{ __('dashboard.total_income') }}</h2>
                <p>€ {{ number_format($totalIncome, 2) }}</p>
            </div>
            <div class="card">
                <h2>{{ __('dashboard.total_expense') }}</h2>
                <p>€ {{ number_format($totalExpense, 2) }}</p>
            </div>
            <div class="card">
                <h2>{{ __('dashboard.net_savings') }}</h2>
                <p>€ {{ number_format($netSavings, 2) }}</p>
            </div>
        </section>

        <section class="expenses-by-category">
            <h2>{{ __('dashboard.expense_by_category') }}</h2>
            <ul>
                @foreach ($expensesByCategory as $expense)
                    <li>{{ $expense->category->name }}: € {{ number_format($expense->total_amount, 2) }}</li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
