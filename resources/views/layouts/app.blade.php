<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Budget Manager') }}</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<nav>
{{--    <a href="{{ route('home') }}">{{ __('Home') }}</a>--}}

    @guest
        <a href="{{ route('login') }}">{{ __('Login') }}</a>
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endguest

    <form action="{{ route('language.switch') }}" method="POST" style="display:inline;">
        @csrf
        <select name="language" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
            <option value="nl" {{ app()->getLocale() === 'nl' ? 'selected' : '' }}>🇳🇱 Nederlands</option>
        </select>
    </form>
</nav>

<div class="wrapper">
    @auth
            @include('components.sidebar')
    @endauth

    <main>
        @yield('content')
    </main>
</div>

</body>
</html>
