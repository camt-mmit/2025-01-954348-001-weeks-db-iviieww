@extends('categories.main', [
    'title' => 'List',
])

@section('header')
    <search>
        <form action="{{ route('categories.list') }}" method="get" class="app-cmp-search-form">
            <label>
                <b>Search</b>
                <input type="text" name="term" value="{{ $criteria['term'] }}" />
            </label><br>
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('categories.list') }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <ul class="app-cmp-links">
            <li><a href="{{ route('categories.create-form') }}">New Categories</a></li>
        </ul>
        <div>
            {{ $categories->withQueryString()->links() }}
        </div>
    </nav>
@endsection

@section('content')

    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>No. of Products</th>
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.categories.create-form', url()->full());
            @endphp
            @php
                session()->put('bookmarks.categories.view', url()->full());
            @endphp
            @foreach ($categories as $category)
                <tr>
                    <td>
                        <a href="{{ Route('categories.view', ['catCode' => $category->code])}}">
                            {{ $category->code }}
                        </a>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>

@endsection