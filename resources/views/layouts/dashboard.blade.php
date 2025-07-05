<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-logo">{{ config('app.name') }}</h1>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <h6 class="nav-section-title">Main</h6>
                    <ul class="nav-items">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @can('create posts')
                            <li>
                                <a href="{{ route('posts.index') }}"
                                    class="{{ request()->routeIs('posts.*') ? 'active' : '' }}">
                                    <i class="fas fa-newspaper"></i>
                                    <span>Posts</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>

                @role('admin')
                    <div class="nav-section">
                        <h6 class="nav-section-title">Admin</h6>
                        <ul class="nav-items">
                            <li>
                                <a href="{{ route('categories.index') }}"
                                    class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                    <i class="fas fa-tags"></i>
                                    <span>Categories</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                @endrole
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">@yield('title', 'Dashboard')</div>
                </div>
                <div class="header-right">
                    <div class="dropdown">
                        <button class="profile-button" data-bs-toggle="dropdown">
                            <div class="profile-info">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                    alt="Profile" class="profile-image">
                                <span class="profile-name">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down profile-arrow"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu profile-dropdown">
                            <li class="dropdown-header">
                                <div class="header-profile">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                        alt="Profile">
                                    <div class="header-profile-info">
                                        <span class="name">{{ Auth::user()->name }}</span>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-circle"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="dashboard-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
