<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar" style="height: 100vh;">
    <h2 class="text-center">{{ __('sidebar.dashboard') }}</h2>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> {{ __('sidebar.dashboard') }}
            </a>
        </li>
        <li>
            <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                <i class="bi bi-cash"></i> {{ __('sidebar.expenses') }}
            </a>
        </li>
        <li>
            <a href="{{ route('incomes.index') }}" class="nav-link {{ request()->routeIs('incomes.index') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> {{ __('sidebar.income') }}
            </a>
        </li>
        <li>
            <a href="{{ route('budgets.index') }}" class="nav-link {{ request()->routeIs('budgets.index') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> {{ __('sidebar.budgets') }}
            </a>
        </li>
        <li>
            <a href="{{ route('forecasts.index') }}" class="nav-link {{ request()->routeIs('forecasts.index') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> {{ __('sidebar.forecast') }}
            </a>
        </li>
        <li>
            <a href="{{ route('transactions.import') }}" class="nav-link {{ request()->routeIs('transactions.import') ? 'active' : '' }}">
                <i class="bi bi-upload"></i> {{ __('sidebar.import') }}
            </a>
        </li>

        @if(auth()->user()->is_admin)
            <li>
                <a href="{{ route('admin.user_overview') }}" class="nav-link {{ request()->routeIs('admin.user_overview') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> {{ __('sidebar.user_overview') }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> {{ __('sidebar.admin_settings') }}
                </a>
            </li>
        @endif
    </ul>

    <div class="mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> {{ __('sidebar.logout') }}
            </button>
        </form>
    </div>
</div>
