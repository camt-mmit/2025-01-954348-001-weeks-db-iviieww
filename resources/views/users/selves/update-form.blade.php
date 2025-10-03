@extends('layouts.main', [
    'title' => $users->email,
])

@section('content')
    <form action="{{ route('users.update', [
        'userCode' => $users->email,
    ]) }}" method="post">
        @csrf

        <label>
            <b>email</b>
            <input type="email" name="email" required value="{{ $users->email }}">
        </label><br>
        <label>
            <b>Name</b>
            <input type="text" name="name" required value="{{ $users->name }}">
        </label><br>

        <label>
            <b>Role</b>
            <pre>{{ $users->role }}</pre>
        </label><br>

        <label>
            <b>Password</b>
            <input type="text" name="password" required value="{{ $users->password }}">
        </label><br>

        <button type="submit">Update</button>
    </form>
@endsection
