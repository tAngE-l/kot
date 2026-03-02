<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $user = User::find(session('user_id'));
        $reservations = Reservation::where('user_id', session('user_id'))->get();
        
        return view('profile.index', ['user' => $user, 'reservations' => $reservations]);
    }
    
    public function update(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $user = User::find(session('user_id'));
        
        if ($request->email) {
            $user->email = $request->email;
        }
        
        if ($request->password) {
            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        
        $user->save();
        
        return back()->with('success', 'Профиль обновлен');
    }
}