@extends('products.main', [
    'title' => 'List',
])

@section('header')
    <search>
        <form action="{{ route('products.list') }}" method="get" class="app-cmp-search-form">
            <label>
                <b>Search</b>
                <input type="text" name="term" value="{{ $criteria['term'] }}" />
            </label><br>
            <label>
                Min Price
                <input type="number" name="minPrice" value="{{ $criteria['minPrice'] }}" step="any" />
            </label><br />
            <label>
                Max Price
                <input type="number" name="maxPrice" value="{{ $criteria['maxPrice'] }}" step="any" />
            </label><br />
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('products.list') }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        @php
            session()->put('bookmarks.products.create-form', url()->full());
        @endphp
        <ul class="app-cmp-links">
            <li><a href="{{ route('products.create-form') }}">New Products</a></li>
        </ul>
        <div>
            {{ $products->withQueryString()->links() }}
        </div>
    </nav>
@endsection

@section('content')
    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Categories</th>
                <th>Price</th>
                <th>NO. of Shops</th>
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.products.view', url()->full());
                session()->put('bookmarks.categories.view', url()->full());
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ Route('products.view', ['product' => $product->code]) }}">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <a href="{{ Route('categories.view',['catCode' => $product->category->code])}}">{{ $product->category->name }}</a>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->shops_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
