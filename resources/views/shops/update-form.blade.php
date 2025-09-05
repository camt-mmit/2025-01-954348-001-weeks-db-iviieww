@extends('products.main', [
    'title' => $shops->code,
])

@section('content')
    <form action="{{ Route('shops.update', [
        'shops' => $shops->code,
    ]) }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ $shops->code }}">
        </label><br>

        <b>Name</b>
        <input type="name" name="name" required value="{{ $shops->name }}">
        </label><br>

        <b>Owner</b>
        <input type="text" name="owner" required value="{{ $shops->owner }}">
        </label><br>

        <b>Latitude</b>
        <input type="number" name="latitude" step="any" required value="{{ $shops->latitude }}">
        </label><br>

        <b>Longitude</b>
        <input type="number" name="longitude" step="any" required value="{{ $shops->longitude }}">
        </label><br>

        <label>
            <b>Address</b>
            <textarea name="address" required cols="80" rows="10">{{ $shops->address }}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>
@endsection
