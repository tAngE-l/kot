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
        $username = $request->input('username');
        $password = $request->input('password');
        
        // Для root - специальная проверка
        if ($username == 'root' && $password == 'root') {
            $user = User::where('username', 'root')->first();
            
            if (!$user) {
                $user = new User();
                $user->username = 'root';
                $user->email = 'root@mail.ru';
                $user->password = password_hash('root', PASSWORD_DEFAULT);
                $user->is_admin = 1;
                $user->save();
            }
            
            session(['user_id' => $user->id, 'username' => $user->username, 'is_admin' => $user->is_admin]);
            return redirect('/admin')->with('success', 'Добро пожаловать, администратор!');
        }
        
        // Поиск пользователя с проверкой хеша
        $user = User::where('username', $username)->first();
        
        if ($user && password_verify($password, $user->password)) {
            session(['user_id' => $user->id, 'username' => $user->username, 'is_admin' => $user->is_admin]);
            return redirect('/')->with('success', 'Вы вошли!');
        }
        
        return back()->with('error', 'Неверный логин или пароль');
    }
    
    public function registerForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        if (empty($request->username) || empty($request->password)) {
            return back()->with('error', 'Заполните все поля');
        }
        
        $exists = User::where('username', $request->username)->first();
        if ($exists) {
            return back()->with('error', 'Такой логин уже есть');
        }
        
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email ?? '';
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->is_admin = 0;
        $user->save();
        
        return redirect('/login')->with('success', 'Регистрация успешна!');
    }
    
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Вы вышли');
    }
}