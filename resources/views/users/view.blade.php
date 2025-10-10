@extends('layouts.main', [
    'title' => $users->name,
])

@section('header')
    <form action="{{ route('users.delete', ['userCode' => $users->email]) }}" method="post" id="app-form-delete">
        @csrf
    </form>

    <ul>
        <li>
            <a
                href="{{ route('users.update-form-user', [
                    'userCode' => $users->email,
                ]) }}">Update</a>
        </li>
        @can('delete', $users)
            @if ($users->email !== \Auth::user()->email)
                <li>
                    <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
                </li>
            @endif
        @endcan
        </li>
        <li>
            <a href="{{ route('users.list') }}">&lt; Back</a>
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
