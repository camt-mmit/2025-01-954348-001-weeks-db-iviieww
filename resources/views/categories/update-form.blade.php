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
            <input type="text" name="code" required value="{{ old('code', $category->code) }}">
        </label><br>

            <b>Name</b>
            <input type="name" name="name" required value="{{ old('name', $category->name) }}">
        </label><br>

        <label>
            <b>Description</b>
            <textarea name="description" required cols="80" rows="10">{{ old('description', $category->description) }}</textarea>
        </label><br>

        <button type="submit">Update</button>
        <a href="{{ route('categories.view',['catCode'=>$category->code]) }}">
            <button type="button">Cancel</button>
        </a>
    </form>

@endsection