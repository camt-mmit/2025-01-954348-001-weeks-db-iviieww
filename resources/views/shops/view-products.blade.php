@extends('shops.main', [
    'title' => $shop->code . ' - product',
])


@section('header')
    <search>
        <form action="{{ route('shops.view-products', ['shops' => $shop->code]) }}" method="get" class="app-cmp-search-form">
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
            <a href="{{ route('shops.view-products',['shops' => $shop->code]) }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <ul class="app-cmp-links">
            @can('update',$shop)
            <li><a href="{{ route('shops.add-products-form', ['shops' => $shop->code]) }}">Add products</a></li>
            @endcan
            <li><a href="{{ session()->get('bookmarks.shops.view-products',route('shops.view', ['shops' => $shop])) }}">Back</a></li>
        </ul>


        <form action="{{ route('shops.remove-product', [
            'shops' => $shop->code,
        ]) }}"
            id="app-form-remove-shop" method="post">@csrf</form>
    </nav>

    <div>
        {{ $products->withQueryString()->links() }}
    </div>
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
                @can('update',$shop)
                <th></th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.shops.add-products-form', url()->full());
                session()->put('bookmarks.categories.view', url()->full());
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
                    <td>
                        <a href="{{ Route('categories.view',['catCode' => $product->category->code])}}">{{ $product->category->name }}</a>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->shops_count }}</td>
                    @can('update',$shop)
                    <td><button type="submit" form="app-form-remove-shop" name="product"
                            value="{{ $product->code }}">remove</button></td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
