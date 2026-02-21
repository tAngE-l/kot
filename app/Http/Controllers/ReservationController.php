<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string'
        ]);

        
        return redirect()->back()->with('success', 'Спасибо! Ваша заявка принята. Мы свяжемся с вами для подтверждения.');
    }
}