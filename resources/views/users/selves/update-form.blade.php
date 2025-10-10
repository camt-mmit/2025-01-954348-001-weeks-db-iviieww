@extends('layouts.main', [
    'title' => $users->email,
])

@section('content')
    <form action="{{ route('users.selves.update') }}" method="post">
        @csrf

        <label>
            <b>email</b>
            <input type="email" name="email"  value="{{ old('email', $users->email) }}" readonly>
        </label><br>
        <label>
            <b>Name</b>
            <input type="text" name="name"  value="{{ old('name', $users->name) }}">
        </label><br>

        <label>
            <b>Role</b>
            @if ($users->email !== \Auth::user()->email)
                <select name="role" id="">
                    <option value="USER" @selected($users->role === 'USER')>
                        USER</option>
                    <option value="ADMIN" @selected($users->role === 'ADMIN')>
                        ADMIN</option>
                </select>
        </label><br>
    @else
        <input type="text" name="role" value="{{ $users->role }}" readonly><br>
        @endif
        <label>
            <b>Password</b>
            <input type="text" name="password" value="" placeholder="Leave blank to not update">
        </label><br>

        <button type="submit">Update</button>
        <a href="{{ route('users.selves.selves-view') }}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection
