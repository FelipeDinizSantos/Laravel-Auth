<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    private function _validate(Request $request): array
    {
        return $request->validate(
            [
                'username' => 'required|min:3|max:30',
                'password' => 'required' // |min:3|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]$/
            ],
            [
                'username.required' => 'O usuário é obrigatório',
                'username.min' => 'O usuário deve ter no mínimo :min caracteres',
                'username.max' => 'O usuário deve ter no máximo :max caracteres',

                'password.required' => 'A senha é obrigatória',
                // 'password.min' => 'A senha deve conter no mínimo :min caracteres',
                // 'password.max' => 'A senha deve conter no máximo :max caracteres',
                // 'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúsucla e um caractere número'
            ]
        );
    }

    public function authenticate(Request $request)
    {
        $credentials = $this->_validate($request);

        $user = User::where('username', $credentials['username'])
            ->where('active', true)
            ->whereNotNull('email_verified_at')
            ->where(function ($query) {
                $query->whereNull('blocked_until')
                    ->orWhere('blocked_until', '<=', now());
            })
            ->first();

        if (!$user) {
            return back()->withInput()->with(['invalid_login' => 'Usuário não encontrado']);
        }

        if (!password_verify($credentials['password'], $user->password)) {
            return back()->withInput()->with(['invalid_login' => 'Senha Incorreta']);
        }

        $user->update([
            'last_login_at' => now(),
            'blocked_until' => null
        ]);

        $request->session()->regenerate();
        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
