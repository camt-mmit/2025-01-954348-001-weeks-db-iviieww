@extends('categories.main', [
    'title' => $category->code,
])

@section('header')
    <form action="{{ route('categories.delete', [
        'catCode' => $category->code,
    ]) }}" method="post"
        id="app-form-delete">
        @csrf
    </form>

    <nav>
        <ul class="app-cmp-links">
            <li>
                <a href="{{ session()->get('bookmarks.categories.view', route('categories.list')) }}">&lt; Back</a>
            </li>
             <li>
                <a href="{{ route('categories.view-products', [
                    'catCode' => $category->code,
                ]) }}">View Shops</a>
            </li>
            @php
                session()->put('bookmarks.categories.view-products', url()->full());
            @endphp
            @can('delete', $category)
            <li>
                <a
                    href="{{ route('categories.update-form', [
                        'catCode' => $category->code,
                    ]) }}">Update</a>
            </li>
            <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
            @endcan
        </ul>
    </nav>
@endsection

@section('content')
    <dl>
        <dt>Code</dt>
        <dd>
            {{ $category->code }}
        </dd>
        <dt>Name</dt>
        <dd>
            {{ $category->name }}
        </dd>
        <pre>{{ $category->description }}</pre>
    </dl>
@endsection
