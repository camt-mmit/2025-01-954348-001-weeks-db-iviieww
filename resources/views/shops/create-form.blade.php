@extends('products.main', [
    'title' => 'Create',
])

@section('content')

    <form action="{{ Route('shops.create') }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required>
        </label><br>
            <b>Name</b>
            <input type="name" name="name" required>
        </label><br>
        <label>
            <b>Owner</b>
            <input type="text" name="owner" required>
        </label><br>
        <label>
            <b>Latitude</b>
            <input type="number" name="latitude" step="any" required>
        </label><br>
        <label>
            <b>Longitude</b>
            <input type="number" name="longitude" step="any" required>
        </label><br>

        <label>
            <b>Address</b>
            <textarea name="address" required cols="80" rows="10"></textarea>
        </label><br>

        <button type="submit">Create</button>
    </form>

@endsection