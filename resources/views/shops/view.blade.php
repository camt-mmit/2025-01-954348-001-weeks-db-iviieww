@extends('shops.main', [
    'title' => $shops->name,
])

@section('header')
    <nav>
        <form action="{{ route('shops.delete', [
            'shops' => $shops->code,
        ]) }}" method="post"
            id="app-form-delete">
            @csrf
        </form>
        <ul class="app-cmp-links">
            <li>
                <a href="{{ route('shops.view-products', [
                    'shops' => $shops->code,
                ]) }}">View Products</a>
            </li>
            <li>
                <a
                    href="{{ route('shops.update-form', [
                        'shops' => $shops->code,
                    ]) }}">Update</a>
            </li>
            <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <dl>
        <dt>Code</dt>
        <dd>
            {{ $shops->code }}
        </dd>
        <dt>Name</dt>
        <dd>
            {{ $shops->name }}
        </dd>
        <dt>Owner</dt>
        <dd>
            {{ $shops->owner }}
        </dd>
        <dt>Location</dt>
        <dd>
            {{ $shops->latitude }} {{ $shops->longitude }}
        </dd>

        <dt>Address</dt>
        <dd>
            <pre>{!!nl2br($shops->address)!!}</pre>
        </dd>
    </dl>
@endsection
