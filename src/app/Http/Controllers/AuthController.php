<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        $contacts = Contact::all();
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // 現在の認証ガード（web）でログアウト
        $request->session()->invalidate(); // セッションを無効化
        $request->session()->regenerateToken(); // 新しいCSRFトークンを生成
        // ログアウト後のリダイレクト先を /login に設定
        return redirect('/login'); // ★ここを /login に変更★
    }
}
