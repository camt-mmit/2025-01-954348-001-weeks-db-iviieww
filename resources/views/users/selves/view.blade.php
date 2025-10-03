@extends('layouts.main', [
    'title' => $users->name,
])
@section('header')
    <ul>
        <li><a href="{{ session()->get('bookmarks.users.view', route('users.list')) }}">Back
            </a>
        </li>
        <li>
            <a href="{{ route('users.update-form', [
                    'userCode' => $users->email,
                ]) }}">Update</a>
            </li>
    </ul>
@endsection

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
