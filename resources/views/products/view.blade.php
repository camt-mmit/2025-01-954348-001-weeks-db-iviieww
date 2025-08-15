@extends('products.main', [
    'title' => $product->name,
])

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
        <dt>Price</dt>
        <dd>
            <span class="app-cl-number">{{ $product->price }}</span>
        </dd>

        <pre>{{ $product->description }}</pre>
    </dl>
@endsection