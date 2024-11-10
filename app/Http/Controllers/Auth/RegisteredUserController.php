<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised()
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'two_factor_token' => Str::random(6),
            'two_factor_expires_at' => now()->addMinutes(10)
        ]);

        $user->notify(new TwoFactorCode($user->two_factor_token));

        return redirect()->route('verify.2fa')->with('email', $user->email);
    }

    public function verify2FA(Request $request): RedirectResponse
    {
        $request->validate([
            'two_factor_token' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
                    ->where('two_factor_token', $request->two_factor_token)
                    ->where('two_factor_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['two_factor_token' => 'Invalid or expired code.']);
        }

        $user->two_factor_token = null;
        $user->two_factor_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
