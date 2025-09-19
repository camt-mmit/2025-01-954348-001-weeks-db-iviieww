@extends('shops.main', [
    'title' => $product->code . ' - shop',
])

@section('header')
    <search>
        <form action="{{ route('products.add-shops-form', ['product' => $product->code]) }}" method="get"
            class="app-cmp-search-form">
            <label>
                <b>Search</b>
                <input type="text" name="term" value="{{ $criteria['term'] }}" />
            </label><br>
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('products.view-shops', ['product' => $product->code]) }}">
                <button type="button" class="accent">X</button>
            </a>
        </form>
    </search>

    <nav class="app-cmp-links-bar">
        <form action="{{ route('products.add-shop', [
            'product' => $product->code,
        ]) }}"
            id="add-form-add-shop" method="post">@csrf</form>

        <ul class="app-cmp-links">
            <li><a href="{{ route('products.view-shops', ['product' => $product->code]) }}">Back</a></li>
        </ul>
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
                <th></th>
            </tr>
        </thead>
        <tbody>
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
                    <td><button type="submit" form="add-form-add-shop" name="shop"
                            value="{{ $shops->code }}">Add</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
