<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:patients', 'unique:practitioners'],
            'phone'    => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'The name may only contain letters and spaces.',
            'phone.regex' => 'The phone number may only contain digits.',
        ]);

        $role = $request->input('role', 'patient');

        if ($role === 'practitioner') {
            $user = Practitioner::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            return redirect()->route('login')->with('status', 'Account created! Please log in to access your portal.');
        }

        // Default registration is for Patients
        $user = Patient::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Redirect to login page instead of auto-logging in
        return redirect()->route('login')->with('status', 'Account created successfully! Please log in to continue.');
    }
}
