@extends('shops.main', [
    'title' => $shop->code . ' - product',
])


@section('header')
    <search>
        <form action="{{ route('shops.add-products-form', ['shops' => $shop->code]) }}" method="get"
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
            <a href="{{ route('products.list') }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <form action="{{ route('shops.add-products', [
            'shops' => $shop->code,
        ]) }}"
            id="add-form-add-product" method="post">@csrf</form>

        <ul class="app-cmp-links">
            <li><a href="{{ session('bookmarks.shops.add-products-form',route('shops.view-products', ['shops' => $shop->code])) }}">Back</a></li>
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
                <th></th>
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
                    <td><button type="submit" name="products" form="add-form-add-product"
                            value="{{ $product->code }}">Add</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
