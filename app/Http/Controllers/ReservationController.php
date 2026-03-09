<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservation.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:500'
        ]);
        
        $reservation = new Reservation();
        $reservation->user_id = session('user_id');
        $reservation->name = $request->name;
        $reservation->phone = $request->phone;
        $reservation->email = $request->email;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->guests = $request->guests;
        $reservation->notes = $request->notes;
        $reservation->status = 'pending';
        $reservation->save();
        
        return redirect('/')->with('success', 'Бронь успешно создана! Мы свяжемся с вами для подтверждения.');
    }
    
    public function userReservations()
    {
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Войдите, чтобы увидеть свои брони');
        }
        
        $reservations = Reservation::where('user_id', session('user_id'))
            ->orderBy('date', 'desc')
            ->get();
        
        return view('profile.reservations', ['reservations' => $reservations]);
    }
    
    public function cancel(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Войдите, чтобы отменить бронь');
        }
        
        $reservation = Reservation::find($id);
        
        if (!$reservation) {
            return back()->with('error', 'Бронь не найдена');
        }
        
        if ($reservation->user_id != session('user_id')) {
            return back()->with('error', 'У вас нет прав на отмену этой брони');
        }
        
        $token = $request->input('token');
        $expectedToken = md5($id . session('user_id') . config('app.key'));
        
        if ($token !== $expectedToken) {
            return back()->with('error', 'Недействительный токен безопасности');
        }
        
        $reservation->status = 'cancelled';
        $reservation->save();
        
        return back()->with('success', 'Бронь успешно отменена');
    }
}