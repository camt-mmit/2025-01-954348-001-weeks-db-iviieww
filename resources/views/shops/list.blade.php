@extends('shops.main', [
    'title' => 'List',
])

@section('header')
    <search>
        <form action="{{ route('shops.list') }}" method="get" class="app-cmp-search-form">
            <label>
                <b>Search</b>
                <input type="text" name="term" value="{{ $criteria['term'] }}" />
            </label><br>
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('shops.list') }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        @php
            session()->put('bookmarks.shops.create-form', url()->full());
        @endphp
        @can('update',$shops)
        <ul class="app-cmp-links">
            <li><a href="{{ route('shops.create-form') }}">New Shops</a></li>
        </ul>
        @endcan
        <div>
            {{ $shops->withQueryString()->links() }}
        </div>
    </nav>
@endsection

@section('content')
    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
                <th>No. of Products</th>
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.shops.view', url()->full());
            @endphp
            @foreach ($shops as $shops)
                <tr>
                    <td>
                        <a href="{{ Route('shops.view', ['shops' => $shops->code]) }}">
                            {{ $shops->code }}
                        </a>
                    </td>
                    <td>{{ $shops->name }}</td>
                    <td>{{ $shops->owner }}</td>
                    <td>{{ $shops->products_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
