@extends('categories.main', [
    'title' => 'Create',
])

@section('content')

    <form action="{{ Route('categories.create') }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ old('code') }}">
        </label><br>
            <b>Name</b>
            <input type="name" name="name" required value="{{ old('name') }}">
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10">{{ old('description') }}</textarea>
        </label><br>

        <button type="submit">Create</button>
         <a href="{{ session()->get('bookmarks.categories.create-form', route('categories.list')) }}">
            <button type="button">Cancel</button>
        </a>
    </form>

@endsection