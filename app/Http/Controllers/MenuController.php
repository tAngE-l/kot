<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::all();
        $menu = [];
        foreach ($items as $item) {
            $menu[$item->category][] = $item;
        }
        return view('menu', ['menu' => $menu]);
    }
}