@extends('layouts.main', [
    'title' => 'Create User',
])

@section('header')
    <ul>
        <li><a href="{{ session()->get('bookmarks.users.create-form', route('users.list')) }}">Back
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <form action="{{ Route('users.create') }}" method="post">
        @csrf

        <label>
            <b>Email</b>
            <input type="email" name="email" required>
        </label><br>
        <label>
            <b>Name</b>
            <input type="text" name="name" required>
        </label><br>
        <label>
            <b>Password</b>
            <input type="password" name="password" required>
        </label><br>
        <b>Role</b>
        <select name="role">
            <option value="">--->please Select<---< /option>
            <option value="USER">User</option>
            <option value="ADMIN">Admin</option>
        </select><br>

        <button type="submit">Create</button>
        <a href="{{ route('users.list') }}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection
