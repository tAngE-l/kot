<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $username = $request->input('username');
        $password = $request->input('password');
        
        // Ищем пользователя в базе данных
        $user = User::where('username', $username)->first();
        
        // Проверяем пароль
        if ($user && password_verify($password, $user->password)) {
            // Сохраняем в сессию
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'is_admin' => $user->is_admin,
                'login_time' => time()
            ]);
            
            // Редирект в зависимости от прав
            if ($user->is_admin == 1) {
                return redirect('/admin')->with('success', 'Добро пожаловать, администратор!');
            }
            
            return redirect('/')->with('success', 'Вы успешно вошли!');
        }
        
        return back()->with('error', 'Неверный логин или пароль');
    }
    
    public function registerForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3'
        ]);
        
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->is_admin = 0;
        $user->save();
        
        return redirect('/login')->with('success', 'Регистрация успешна!');
    }
    
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}