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
        $reservation = new Reservation();
        $reservation->user_id = session('user_id') ?? null;
        $reservation->name = $request->name;
        $reservation->phone = $request->phone;
        $reservation->email = $request->email;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->guests = $request->guests;
        $reservation->notes = $request->notes;
        $reservation->status = 'pending';
        $reservation->save();
        
        return redirect('/')->with('success', 'Бронь создана!');
    }
    
    public function userReservations()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $reservations = Reservation::where('user_id', session('user_id'))->get();
        return view('profile.reservations', ['reservations' => $reservations]);
    }
    
    public function cancel($id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $reservation = Reservation::find($id);
        
        if ($reservation->user_id == session('user_id')) {
            $reservation->status = 'cancelled';
            $reservation->save();
        }
        
        return back()->with('success', 'Бронь отменена');
    }
}