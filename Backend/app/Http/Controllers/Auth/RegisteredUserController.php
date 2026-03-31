<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminRegistrationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role'     => ['required', 'string', 'in:admin,user'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Admin registrations start as pending, employees are auto-approved
        $status = $request->role === 'admin' ? 'pending' : 'approved';

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $status,
        ]);

        event(new Registered($user));

        // If admin, notify all existing approved admins and don't log in yet
        if ($request->role === 'admin') {
            $admins = User::where('role', 'admin')
                          ->where('status', 'approved')
                          ->where('id', '!=', $user->id)
                          ->get();

            foreach ($admins as $admin) {
                $admin->notify(new AdminRegistrationRequest($user));
            }

            return redirect()->route('login')
                ->with('status', 'Your admin registration request has been submitted. Please wait for approval.');
        }

        // Employees log in immediately
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }
}