@extends('categories.main', [
    'title' => $category->code,
])

@section('content')

    <form action="{{ Route('categories.update', [
        'catCode' => $category->code,
    ])}}" method="post">
        @csrf

        <label>
            <b>Code</b>
            <input type="text" name="code" required value="{{ $category->code }}">
        </label><br>

            <b>Name</b>
            <input type="name" name="name" required value="{{ $category->name }}">
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10">{{ $category->description }}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>

@endsection