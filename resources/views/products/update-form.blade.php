@extends('products.main', [
    'title' => $product->code,
])

@section('content')
    <form action="{{ Route('products.update', [
        'product' => $product->code,
    ]) }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ old('code', $product->code) }}">
        </label><br>

        <b>Name</b>
        <input type="name" name="name" required value="{{ old('name', $product->name) }}">
        </label><br>

        <b>Category</b>
        <select name="category" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->code }}"
                    @selected($category->code === old('category', $product->category->code))
                    >[{{ $category->code }}] {{ $category->name }}</option>
            @endforeach
        </select><br>

        <b>Price</b>
        <input type="number" name="price" step="any" required value="{{ old('price', $product->price) }}">
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10">{{ old('description', $product->description) }}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>
@endsection
