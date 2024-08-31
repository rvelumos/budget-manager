@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
    <div class="container">
        <h1 class="display-4 text-primary">{{ __('messages.welcome') }}</h1>
        <p class="lead">{{ __('messages.manage_finances') }}</p>

        <!-- Vue Components for Diagrams -->
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <chart-component
                            type="expenses"
                            title="{{ __('messages.expenses_chart_title') }}"
                            chart-id="expensesChart">
                        </chart-component>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <chart-component
                            type="income"
                            title="{{ __('messages.income_chart_title') }}"
                            chart-id="incomeChart">
                        </chart-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
