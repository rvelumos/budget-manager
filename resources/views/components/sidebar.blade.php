<div class="sidebar bg-light">
    <h2 class="text-center">{{ __('sidebar.dashboard') }}</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('home') }}">{{ __('sidebar.dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('expense.index') }}">{{ __('sidebar.expenses') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('income.index') }}">{{ __('sidebar.income') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transaction.import') }}">{{ __('sidebar.import') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('forecast.index') }}">{{ __('sidebar.forecast') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.account') }}">{{ __('sidebar.settings') }}</a>
        </li>

        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user_overview') }}">{{ __('sidebar.user_overview') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">{{ __('sidebar.admin_settings') }}</a>
            </li>
        @endif
    </ul>

    <div class="mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">{{ __('sidebar.logout') }}</button>
        </form>
    </div>
</div>
