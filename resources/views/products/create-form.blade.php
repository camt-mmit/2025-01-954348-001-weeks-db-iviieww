@extends('products.main', [
    'title' => 'Create',
])

@section('content')

    <form action="{{ Route('products.create') }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required>
        </label><br>
            <b>Name</b>
            <input type="name" name="name" required>
        </label><br>
            <b>Price</b>
            <input type="number" name="price" step="any" required>
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10"></textarea>
        </label><br>

        <button type="submit">Create</button>
    </form>

@endsection