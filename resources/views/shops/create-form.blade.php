@extends('shops.main', [
    'title' => 'Create',
])

@section('content')

    <form action="{{ Route('shops.create') }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ old('code') }}">
        </label><br>
            <b>Name</b>
            <input type="name" name="name" required value="{{ old('name') }}">
        </label><br>
        <label>
            <b>Owner</b>
            <input type="text" name="owner" required value="{{ old('owner') }}">
        </label><br>
        <label>
            <b>Latitude</b>
            <input type="number" name="latitude" step="any" required value="{{ old('latitude') }}">
        </label><br>
        <label>
            <b>Longitude</b>
            <input type="number" name="longitude" step="any" required value="{{ old('longitude') }}">
        </label><br>

        <label>
            <b>Address</b>
            <textarea name="address" required cols="80" rows="10">{{ old('address') }}</textarea>
        </label><br>

        <button type="submit">Create</button>
        <a href="{{ session()->get('bookmarks.shops.create-form', route('shops.list')) }}">
            <button type="button">Cancel</button>
        </a>
    </form>

@endsection