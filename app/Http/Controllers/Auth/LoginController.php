<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 実行
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');   // ←要件「管理画面に遷移」
        }

        return back()
            ->withErrors(['email' => '認証に失敗しました。メールアドレスまたはパスワードをご確認ください。'])
            ->onlyInput('email');
    }

    // ログアウト
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
