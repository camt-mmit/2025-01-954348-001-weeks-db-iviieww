@extends('products.main', [
    'title' => $product->code,
])

@section('content')

    <form action="{{ Route('products.update', [
        'product' => $product->code,
    ])}}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ $product->code }}">
        </label><br>

            <b>Name</b>
            <input type="name" name="name" required value="{{ $product->name }}">
        </label><br>
        
            <b>Price</b>
            <input type="number" name="price" step="any" required value="{{ $product->price }}">
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10">{{ $product->description }}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>

@endsection