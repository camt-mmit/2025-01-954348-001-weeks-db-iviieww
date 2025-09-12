@extends('products.main', [
    'title' => $product->name,
])

@section('header')
    <nav>
        <form action="{{ route('products.delete', [
            'product' => $product->code,
        ]) }}" method="post" id="app-form-delete">
            @csrf
        </form>
        <ul class="app-cmp-links">
            <li>
                <a href="{{ route('products.view-shops', [
                    'product' => $product->code,
                ]) }}">View Shops</a>
            </li>
            <li>
                <a href="{{ route('products.update-form', [
                    'product' => $product->code,
                ]) }}">Update</a>
            </li>
            <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <dl>
        <dt>Code</dt>
        <dd>
            {{ $product->code }}
        </dd>
        <dt>Name</dt>
        <dd>
            {{ $product->name }}
        </dd>
        <dt>Categories</dt>
        <dd>{{ $product->category->name }}</dd>
        <dt>Price</dt>
        <dd>
            <span class="app-cl-number">{{ $product->price }}</span>
        </dd>

        <pre>{{ $product->description }}</pre>
    </dl>
@endsection
