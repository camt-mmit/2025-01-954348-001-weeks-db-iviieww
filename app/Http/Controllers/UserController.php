<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('list', User::class);
        $users = $user->getQuery()->get();
        return View('users.list', [
            'users' => $users,
        ]);
    }

    function showCreateForm(): View
    {
        Gate::authorize('create', User::class);
        return view('users.create-form');
    }

    function create(
        ServerRequestInterface $request,
    ): RedirectResponse {
        Gate::authorize('create', User::class);
        try {
            $data = $request->getParsedBody();
            $user = new User();
            $user->fill($data);
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->save();

            return redirect()->route('users.list')
                ->with('status', "User {$user->email} was created.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function selvesUpdateForm(): View
    {
        $user = User::where('email', auth::user()->email)->firstOrFail();
        return view('users.selves.update-form', [
            'users' => $user,
        ]);
    }

    function updateForm(
        string $userCode,
    ): View {
        $user = User::where('email', $userCode)->firstOrFail();
        Gate::authorize('update', User::class);
        return view('users.update-form-user', [
            'users' => $user,
        ]);
    }

    function Update(
        ServerRequestInterface $request,
        string $userCode,
    ): RedirectResponse {
        Gate::authorize('update', User::class);
        try {
            $user = User::where('email', $userCode)->firstOrFail();
            $data = $request->getParsedBody();
            $password = $user->password;
            $user->fill($data);
            $user->email = $data['email'];
            $user->role = $data['role'];
            if ($data['password'] !== null) {
                $user->password = $data['password'];
            } else {
                $user->password = $password;
            }
            $user->save();

            return redirect()->route('users.view', [
                'userCode' => $user->email,
            ])
                ->with('status', "User {$user->email} was updated.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function SelvesUpdate(
        ServerRequestInterface $request,
    ): RedirectResponse {
        try {
            $user = User::where('email', auth::user()->email)->firstOrFail();
            $data = $request->getParsedBody();
            $password = $user->password;
            $user->fill($data);
            $user->email = $data['email'];
            $user->role = $data['role'];
            if ($data['password'] !== null) {
                $user->password = $data['password'];
            } else {
                $user->password = $password;
            }
            $user->save();

            return redirect()->route('users.selves.selves-view')
                ->with('status', "User {$user->email} was updated.");
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }

    function delete(string $userCode): RedirectResponse
    {
        $user = User::where('email', $userCode)->firstOrFail();
        Gate::authorize('delete', $user);
        try {
            $user->delete();
            Gate::authorize('delete', User::class);
            return redirect(
                session()->get('bookmarks.user.view', route('users.list'))
            )
                ->with('status', 'User ' . $user->name . ' was Deleted');
        } catch (QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
