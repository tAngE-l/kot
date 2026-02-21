<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {
        // Берем первые 4 блюда для главной
        $recommended = MenuItem::limit(4)->get();
        return view('home', ['recommended' => $recommended]);
    }
}