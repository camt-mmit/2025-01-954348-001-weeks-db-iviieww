<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    function view(string $userCode): View
    {
        $user = User::where('email', $userCode)->firstOrFail();

        return View('users.view', [
            'users' => $user,
        ]);
    }

    function selvesView(): View
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->firstOrFail();

        return View('users.selves.view', [
            'users' => $user,
        ]);
    }

    function list(User $user): View
    {
        $users = $user->getQuery()->get();
        return View('users.list', [
            'users' => $users,
        ]);
    }

    function showCreateForm(): View
    {
        return view('users.create-form');
    }

    function create(
        ServerRequestInterface $request,
    ): RedirectResponse {
        $data = $request->getParsedBody();

        $user = new User();
        $user->fill($data);
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('users.list')
        ->with('status', "User {$user->email} was created.");
    }

    function updateForm(
        string $userCode,
    ): View {
        $user = User::where('email', $userCode)->firstOrFail();

        return view('users.selves.update-form', [
            'users' => $user,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        User $user,
        string $userCode,
    ): RedirectResponse {
        $user = User::where('email', $userCode)->firstOrFail();
        $data = $request->getParsedBody();

        $user->fill($data);
        $user->save();

        return redirect()->route('users.selves.view')
        ->with('status', "User {$user->email} was updated.");
    }
}
