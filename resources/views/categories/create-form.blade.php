@extends('categories.main', [
    'title' => 'Create',
])

@section('content')

    <form action="{{ Route('categories.create') }}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required>
        </label><br>
            <b>Name</b>
            <input type="name" name="name" required>
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10"></textarea>
        </label><br>

        <button type="submit">Create</button>
         <a href="{{ session()->get('bookmarks.categories.create-form', route('categories.list')) }}">
            <button type="button">Cancel</button>
        </a>
    </form>

@endsection