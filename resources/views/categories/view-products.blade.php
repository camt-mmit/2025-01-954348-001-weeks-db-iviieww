@extends('categories.main', [
    'title' => $categories->code . ' - product',
])


@section('header')
    <search>
        <form action="{{ route('categories.view-products', ['catCode' => $categories->code]) }}" method="get"
            class="app-cmp-search-form">
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
            <a href="{{ route('categories.view-products',['catCode' => $categories->code]) }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <ul class="app-cmp-links">
            @can('update', $categories)
            <li><a href="{{ route('categories.add-products-form', ['catCode' => $categories->code]) }}">Add Product</a></li>
            @endcan
            <li><a href="{{ session()->get('bookmarks.categories.view-products', route('categories.view', ['catCode' => $categories->code])) }}">Back</a></li>
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
                session()->put('bookmarks.categories.add-products-form', url()->full());
                session()->put('bookmarks.products.view', url()->full());
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ Route('products.view', ['product' => $product->code]) }}">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->shops_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
