<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/customer/dashboard';

    public function showLoginForm(Request $request)
    {
        $redirect = $request->query('redirect_to');

        if (
            $redirect &&
            str_starts_with($redirect, '/') &&
            !str_starts_with($redirect, '//')
        ) {
            $request->session()->put('login.redirect', $redirect);
        }

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            $request->session()->forget('login.redirect');

            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'customer') {
            $redirect = $request->session()->pull('login.redirect');

            if (
                $redirect &&
                str_starts_with($redirect, '/') &&
                !str_starts_with($redirect, '//')
            ) {
                return redirect()->to($redirect);
            }

            return redirect()->route('customer.dashboard');
        }

        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
