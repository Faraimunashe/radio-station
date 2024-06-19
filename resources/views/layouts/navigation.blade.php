<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="{{ route('dashboard') }}">
        <img class="navbar-brand-dark" src="{{ asset('assets/img/brand/light.svg') }}" alt="Work Force logo" />
        <img class="navbar-brand-light" src="{{ asset('assets/img/brand/dark.svg') }}" alt="Work Force logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-info text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{ asset('images/user-icon.jpg') }}" class="card-img-top rounded-circle border-white" alt="Bonnie Green">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi, {{ Auth::user()->name }}</h2>
                    <a href="#" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                        <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
                <span class="sidebar-icon">
                    <img src="{{ asset('assets/img/brand/light.svg') }}" height="20" width="20" alt="Volt Logo">
                </span>
                <span class="mt-1 ms-1 sidebar-text">Radio Station Sys</span>
                </a>
            </li>
            <li class="nav-item  {{ request()->routeIs('dashboard') ? 'active' : '' }} ">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <x-icon name="chart-pie" class="icon icon-xs me-2"/>
                    </span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->hasRole('admin'))
                <li class="nav-item {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                    <a href="{{ route('employees.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="user-group" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Employees</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasRole('archivist'))
                <li class="nav-item {{ request()->routeIs('musics.index') ? 'active' : '' }}">
                    <a href="{{ route('musics.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="musical-note" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Music</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('archivist-playlists') ? 'active' : '' }}">
                    <a href="{{ route('archivist-playlists') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="list-bullet" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Playlists</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasRole('ep'))
                <li class="nav-item {{ request()->routeIs('schedules.index') ? 'active' : '' }}">
                    <a href="{{ route('schedules.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Schedules</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('ep-script') ? 'active' : '' }}">
                    <a href="{{ route('ep-script') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Scripts</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('jingles.index') ? 'active' : '' }}">
                    <a href="{{ route('jingles.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="musical-note" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Jingles</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('finances.index') ? 'active' : '' }}">
                    <a href="{{ route('finances.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="cursor-arrow-rays" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Finances</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('ep-adverts.index') ? 'active' : '' }}">
                    <a href="{{ route('ep-adverts.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Advertisements</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasRole('presenter'))
                <li class="nav-item {{ request()->routeIs('presenter-schedule') ? 'active' : '' }}">
                    <a href="{{ route('presenter-schedule') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Schedules</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('scripts.index') ? 'active' : '' }}">
                    <a href="{{ route('scripts.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Scripts</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('playlists.index') ? 'active' : '' }}">
                    <a href="{{ route('playlists.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="document-text" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Playlist</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasRole('audience'))
                <li class="nav-item {{ request()->routeIs('adverts.index') ? 'active' : '' }}">
                    <a href="{{ route('adverts.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            <x-icon name="clock" class="icon icon-xs me-2"/>
                        </span>
                        <span class="sidebar-text">Advertisements</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
