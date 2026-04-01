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
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role'     => ['required', 'string', 'in:admin,user'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Admins start as pending, employees are auto-approved
        $status = $request->role === 'admin' ? 'pending' : 'approved';

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $status,
        ]);

        event(new Registered($user));

        // If registering as admin, notify all existing approved admins
        if ($request->role === 'admin') {
            $existingAdmins = User::where('role', 'admin')
                                  ->where('status', 'approved')
                                  ->where('id', '!=', $user->id)
                                  ->get();

            foreach ($existingAdmins as $admin) {
                $admin->notify(new AdminRegistrationRequest($user));
            }

            // Don't log in — send back to login with a message
            return redirect()->route('login')
                ->with('status', 'Your admin registration request has been submitted. Please wait for approval.');
        }

        // Employees log in immediately
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }
}