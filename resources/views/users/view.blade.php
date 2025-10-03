@extends('layouts.main', [
    'title' => $users->name,
])


@section('content')
    <dl>
        <dt>Email</dt>
        <dd>
            {{ $users->email }}
        </dd>
        <dt>Name</dt>
        <dd>
            {{ $users->name }}
        </dd>
        <dt>Role</dt>
        <dd>{{ $users->role }}</dd>
    </dl>
@endsection
