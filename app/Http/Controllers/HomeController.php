<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {
        $recommended = MenuItem::limit(4)->get();
        return view('home', ['recommended' => $recommended]);
    }
}