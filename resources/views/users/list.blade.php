@extends('layouts.main', [
    'title' => 'Users',
])

@section('header')
    @php
        session()->put('bookmarks.users.create-form', url()->full());
    @endphp
    <ul class="app-cmp-links">
        <li><a href="{{ route('users.create-form') }}">New Users</a></li>
    </ul>
@endsection
@section('content')
    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('users.view', ['userCode' => $user->email]) }}">
                            {{ $user->email }}
                        </a>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
