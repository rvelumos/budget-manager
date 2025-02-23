<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar" style="height: 100vh;">
    <h2 class="text-center">{{ __('home.title_short') }}</h2>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-house-door"></i> {{ __('sidebar.dashboard') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('expense-listings.index') }}" class="nav-link {{ request()->routeIs('expense-listings.index') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-cash"></i> {{ __('sidebar.expenses') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('income-listings.index') }}" class="nav-link {{ request()->routeIs('income-listings.index') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-wallet2"></i> {{ __('sidebar.incomes') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('budgets.index') }}" class="nav-link {{ request()->routeIs('budgets.index') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-graph-up"></i> {{ __('sidebar.budgets') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('forecasts.index') }}" class="nav-link {{ request()->routeIs('forecasts.index') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-calendar3"></i> {{ __('sidebar.forecast') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('transactions.import') }}" class="nav-link {{ request()->routeIs('transactions.import') ? 'active' : '' }}">
                <div class="menu-item">
                    <span><i class="bi bi-upload"></i> {{ __('sidebar.import') }}</span>
                    <span class="arrow">&#10095;</span>
                </div>
            </a>
        </li>

        @if(auth()->user()->is_admin)
            <li>
                <a href="{{ route('admin.user_overview') }}" class="nav-link {{ request()->routeIs('admin.user_overview') ? 'active' : '' }}">
                    <div class="menu-item">
                        <span><i class="bi bi-people"></i> {{ __('sidebar.user_overview') }}</span>
                        <span class="arrow">&#10095;</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <div class="menu-item">
                        <span><i class="bi bi-gear"></i> {{ __('sidebar.admin_settings') }}</span>
                        <span class="arrow">&#10095;</span>
                    </div>
                </a>
            </li>
        @endif
    </ul>

    <div class="mt-auto" style="text-align: center;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-200 logout-btn">
                <i class="bi bi-box-arrow-right"></i> {{ __('sidebar.logout') }}
            </button>
        </form>
    </div>
</div>
