<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\User;

class AdminController extends Controller
{
    
    public function index()
    {
      
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
      
        $items = MenuItem::all();
      
        return view('admin.index', ['items' => $items]);
    }
    
   
    public function create()
    {
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
        return view('admin.create');
    }
    
  
    public function store(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
        $item = new MenuItem();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->save();
        
        return redirect('/admin')->with('success', 'Блюдо добавлено');
    }
    
 
    public function edit($id)
    {
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
        $item = MenuItem::find($id);
        return view('admin.edit', ['item' => $item]);
    }
  
    public function update(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
        $item = MenuItem::find($id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->save();
        
        return redirect('/admin')->with('success', 'Блюдо обновлено');
    }
    
    
    public function delete($id)
    {
        if (!session('user_id')) {
            return redirect('/')->with('error', 'Сначала войдите в систему');
        }
        
        $item = MenuItem::find($id);
        $item->delete();
        
        return redirect('/admin')->with('success', 'Блюдо удалено');
    }
}