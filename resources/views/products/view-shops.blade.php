@extends('shops.main', [
    'title' => $product->code . ' - shop',
])

@section('header')
    <search>
        <form action="{{ route('products.view-shops', ['product' => $productCode]) }}" method="get"
            class="app-cmp-search-form">
            <label>
                <b>Search</b>
                <input type="text" name="term" value="{{ $criteria['term'] }}" />
            </label><br>
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('products.view-shops', ['product' => $productCode]) }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <ul class="app-cmp-links">
            <li><a href="{{ route('products.add-shops-form', ['product' => $product->code]) }}">Add Shops</a></li>
            <li><a href="{{ session()->get('bookmarks.products.view-shops', route('products.view', ['product' => $productCode])) }}">Back</a></li>
        </ul>
        <div>
            {{ $shops->withQueryString()->links() }}
        </div>

        <form action="{{ route('products.remove-shop', [
            'product' => $product->code,
        ]) }}"
            id="app-form-remove-shop" method="post">@csrf</form>
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
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                session()->put('bookmarks.products.add-shops-form', url()->full());
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
                    <td><button type="submit" form="app-form-remove-shop" name="shop"
                            value="{{ $shops->code }}">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
