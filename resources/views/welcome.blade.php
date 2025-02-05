@extends('layouts.app')

@section('content')
    <div class="home-container">
        <header>
            <h1>{{ __('home.title') }}</h1>
            <p>{{ __('home.subtitle') }}</p>
            <a href="{{ route('register') }}" class="btn-primary">{{ __('home.cta_register') }}</a>
        </header>

        <section class="features">
            <div class="feature">
                <h2>💰 {{ __('home.features.track_expenses.title') }}</h2>
                <p>{{ __('home.features.track_expenses.description') }}</p>
            </div>
            <div class="feature">
                <h2>📊 {{ __('home.features.forecast.title') }}</h2>
                <p>{{ __('home.features.forecast.description') }}</p>
            </div>
            <div class="feature">
                <h2>🔄 {{ __('home.features.recurring_transactions.title') }}</h2>
                <p>{{ __('home.features.recurring_transactions.description') }}</p>
            </div>
            <div class="feature">
                <h2>📅 {{ __('home.features.budgeting.title') }}</h2>
                <p>{{ __('home.features.budgeting.description') }}</p>
            </div>
            <div class="feature">
                <h2>🔒 {{ __('home.features.security.title') }}</h2>
                <p>{{ __('home.features.security.description') }}</p>
            </div>
        </section>

        <footer>
            <p>{{ __('home.cta_login_text') }} <a href="{{ route('login') }}">{{ __('home.cta_login') }}</a></p>
        </footer>
    </div>
@endsection
