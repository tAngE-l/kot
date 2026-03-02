<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Сначала войдите');
        }
        
        $items = MenuItem::all();
        $stats = [
            'dishes' => MenuItem::count(),
            'reservations' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'users' => User::count()
        ];
        $recentReservations = Reservation::orderBy('id', 'desc')->limit(5)->get();
        
        return view('admin.index', [
            'items' => $items,
            'stats' => $stats,
            'recentReservations' => $recentReservations
        ]);
    }
    
    public function dishes()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $items = MenuItem::all();
        return view('admin.dishes', ['items' => $items]);
    }
    
    public function createDish()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        return view('admin.dish-create');
    }
    
    public function storeDish(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,jfif,bmp,webp|max:5120'
        ]);
        
        $item = new MenuItem();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.jfif';
            
            // Создаем изображение из загруженного файла
            $img = null;
            $extension = strtolower($image->getClientOriginalExtension());
            
            if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'jfif') {
                $img = imagecreatefromjpeg($image->getRealPath());
            } elseif ($extension == 'png') {
                $img = imagecreatefrompng($image->getRealPath());
            } elseif ($extension == 'gif') {
                $img = imagecreatefromgif($image->getRealPath());
            } elseif ($extension == 'bmp') {
                $img = imagecreatefrombmp($image->getRealPath());
            } elseif ($extension == 'webp') {
                $img = imagecreatefromwebp($image->getRealPath());
            }
            
            if ($img) {
                // Сохраняем как JFIF
                imagejpeg($img, public_path('uploads/menu/' . $imageName), 90);
                imagedestroy($img);
                $item->image = $imageName;
            }
        }
        
        $item->save();
        return redirect('/admin/dishes')->with('success', 'Блюдо добавлено');
    }
    
    public function editDish($id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $item = MenuItem::find($id);
        return view('admin.dish-edit', ['item' => $item]);
    }
    
    public function updateDish(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif,bmp,webp|max:5120'
        ]);
        
        $item = MenuItem::find($id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        
        if ($request->hasFile('image')) {
            // Удаляем старое фото
            if ($item->image && file_exists(public_path('uploads/menu/' . $item->image))) {
                unlink(public_path('uploads/menu/' . $item->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.jfif';
            
            // Создаем изображение из загруженного файла
            $img = null;
            $extension = strtolower($image->getClientOriginalExtension());
            
            if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'jfif') {
                $img = imagecreatefromjpeg($image->getRealPath());
            } elseif ($extension == 'png') {
                $img = imagecreatefrompng($image->getRealPath());
            } elseif ($extension == 'gif') {
                $img = imagecreatefromgif($image->getRealPath());
            } elseif ($extension == 'bmp') {
                $img = imagecreatefrombmp($image->getRealPath());
            } elseif ($extension == 'webp') {
                $img = imagecreatefromwebp($image->getRealPath());
            }
            
            if ($img) {
                // Сохраняем как JFIF
                imagejpeg($img, public_path('uploads/menu/' . $imageName), 90);
                imagedestroy($img);
                $item->image = $imageName;
            }
        }
        
        $item->save();
        return redirect('/admin/dishes')->with('success', 'Блюдо обновлено');
    }
    
    public function deleteDish($id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $item = MenuItem::find($id);
        if ($item->image && file_exists(public_path('uploads/menu/' . $item->image))) {
            unlink(public_path('uploads/menu/' . $item->image));
        }
        $item->delete();
        return redirect('/admin/dishes')->with('success', 'Блюдо удалено');
    }
    
    public function reservations()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $reservations = Reservation::orderBy('date', 'desc')->get();
        return view('admin.reservations', ['reservations' => $reservations]);
    }
    
    public function editReservation($id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $reservation = Reservation::find($id);
        return view('admin.reservation-edit', ['reservation' => $reservation]);
    }
    
    public function updateReservation(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        
        $reservation = Reservation::find($id);
        $reservation->status = $request->status;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->guests = $request->guests;
        $reservation->notes = $request->notes;
        $reservation->save();
        
        return redirect('/admin/reservations')->with('success', 'Бронь обновлена');
    }
    
    public function deleteReservation($id)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }
        $reservation = Reservation::find($id);
        $reservation->delete();
        return redirect('/admin/reservations')->with('success', 'Бронь удалена');
    }
}