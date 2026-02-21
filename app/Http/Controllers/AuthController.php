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
        
       
        if ($username == 'root' && $password == 'root') {
            
            $user = User::where('username', 'root')->first();
            
          
            if (!$user) {
                $user = new User();
                $user->username = 'root';
                $user->email = 'admin@restaurant.ru';
                $user->password = password_hash('root', PASSWORD_DEFAULT);
                $user->is_admin = 1;
                $user->save();
            }
            
           
            session(['user_id' => $user->id, 'username' => $user->username, 'is_admin' => 1]);
            return redirect('/admin')->with('success', 'Добро пожаловать, администратор!');
        }
        
       
        $user = User::where('username', $username)->first();
        
        if ($user && password_verify($password, $user->password)) {
            session([
                'user_id' => $user->id, 
                'username' => $user->username, 
                'is_admin' => $user->is_admin
            ]);
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
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3'
        ]);
        
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->is_admin = 0;
        $user->save();
        
        return redirect('/login')->with('success', 'Регистрация успешна! Теперь вы можете войти.');
    }
    
    
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}