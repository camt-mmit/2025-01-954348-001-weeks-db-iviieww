<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <header id="app-cmp-main-header">
        <nav>
            <ul class="app-cmp-links">
                <li><a href="{{ route('products.list') }}">Product</a></li>
                <li><a href="{{ route('shops.list') }}">shops</a></li>
                <li><a href="{{ route('categories.list') }}">Categories</a></li>
                @can('create', \App\Models\User::class)
                    <li><a href="{{ route('users.list') }}">Users</a></li>
                @endcan
            </ul>
        </nav>

        @php
            session()->put('bookmarks.users.view', url()->full());
        @endphp

        @auth
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <a href="{{ Route('users.selves.selves-view') }}">
                    <span>{{ \Auth::user()->name }}</span>
                </a>
                <button type="submit">Logout</button>
            </form>
        @endauth
    </header>

    <main id="app-cmp-main-content">
        <header>
            <h1>{{ $title }}</h1>
            @yield('header')
        </header>
        <div class="app-cmp-notifications">
            {{-- status message --}}

            @error('alert')
                <div role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="app-cmp-notifications">
            @session('status')
                <div role="status">
                    {{ $value }}
                </div>
            @endsession
        </div>

        @yield('content')
    </main>

    <footer id="app-cmp-main-footer">
        Created by Nantapop Yuanjai, Student ID: 662110066
    </footer>
</body>

</html>
