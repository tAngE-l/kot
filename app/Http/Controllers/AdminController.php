<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Проверка прав администратора с актуализацией данных из БД
     */
    private function checkAdmin()
    {
        // Проверяем, авторизован ли пользователь
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Сначала войдите в систему');
        }
        
        // ПОЛУЧАЕМ АКТУАЛЬНЫЕ ДАННЫЕ ИЗ БАЗЫ ДАННЫХ
        $user = User::find(session('user_id'));
        
        // Проверяем, существует ли пользователь
        if (!$user) {
            session()->flush();
            return redirect('/login')->with('error', 'Пользователь не найден');
        }
        
        // ОБНОВЛЯЕМ СЕССИЮ АКТУАЛЬНЫМИ ДАННЫМИ ИЗ БД
        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'is_admin' => $user->is_admin  // Берем свежее значение из БД!
        ]);
        
        // Проверяем, является ли пользователь администратором
        if ($user->is_admin != 1) {
            return redirect('/')->with('error', 'У вас нет прав доступа к админ-панели');
        }
        
        return null; // Всё хорошо, доступ разрешен
    }
    
    // Токены для удаления
    private function generateToken($id)
    {
        return md5($id . session('user_id') . config('app.key'));
    }
    
    private function validateToken($id, $token)
    {
        return $token === md5($id . session('user_id') . config('app.key'));
    }
    
    public function index()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
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
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $items = MenuItem::all();
        return view('admin.dishes', ['items' => $items]);
    }
    
    public function createDish()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        return view('admin.dish-create');
    }
    
    public function storeDish(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $item = new MenuItem();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/menu'), $imageName);
            $item->image = $imageName;
        }
        
        $item->save();
        
        return redirect('/admin/dishes')->with('success', 'Блюдо успешно добавлено');
    }
    
    public function editDish($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $item = MenuItem::find($id);
        
        if (!$item) {
            return redirect('/admin/dishes')->with('error', 'Блюдо не найдено');
        }
        
        return view('admin.dish-edit', ['item' => $item]);
    }
    
    public function updateDish(Request $request, $id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $item = MenuItem::find($id);
        
        if (!$item) {
            return redirect('/admin/dishes')->with('error', 'Блюдо не найдено');
        }
        
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category = $request->category;
        
        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path('uploads/menu/' . $item->image))) {
                unlink(public_path('uploads/menu/' . $item->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/menu'), $imageName);
            $item->image = $imageName;
        }
        
        $item->save();
        
        return redirect('/admin/dishes')->with('success', 'Блюдо успешно обновлено');
    }
    
    public function deleteDish(Request $request, $id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $token = $request->input('token');
        if (!$this->validateToken($id, $token)) {
            return redirect('/admin/dishes')->with('error', 'Недействительный токен безопасности');
        }
        
        $item = MenuItem::find($id);
        
        if (!$item) {
            return redirect('/admin/dishes')->with('error', 'Блюдо не найдено');
        }
        
        if ($item->image && file_exists(public_path('uploads/menu/' . $item->image))) {
            unlink(public_path('uploads/menu/' . $item->image));
        }
        
        $item->delete();
        
        return redirect('/admin/dishes')->with('success', 'Блюдо успешно удалено');
    }
    
    public function reservations()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $reservations = Reservation::orderBy('created_at', 'desc')->get();
        return view('admin.reservations', ['reservations' => $reservations]);
    }
    
    public function editReservation($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $reservation = Reservation::find($id);
        
        if (!$reservation) {
            return redirect('/admin/reservations')->with('error', 'Бронь не найдена');
        }
        
        return view('admin.reservation-edit', ['reservation' => $reservation]);
    }
    
    public function updateReservation(Request $request, $id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'date' => 'required|date',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string'
        ]);
        
        $reservation = Reservation::find($id);
        
        if (!$reservation) {
            return redirect('/admin/reservations')->with('error', 'Бронь не найдена');
        }
        
        $reservation->status = $request->status;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->guests = $request->guests;
        $reservation->notes = $request->notes;
        $reservation->save();
        
        return redirect('/admin/reservations')->with('success', 'Бронь успешно обновлена');
    }
    
    public function deleteReservation(Request $request, $id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;
        
        $token = $request->input('token');
        if (!$this->validateToken($id, $token)) {
            return redirect('/admin/reservations')->with('error', 'Недействительный токен безопасности');
        }
        
        $reservation = Reservation::find($id);
        
        if (!$reservation) {
            return redirect('/admin/reservations')->with('error', 'Бронь не найдена');
        }
        
        $reservation->delete();
        
        return redirect('/admin/reservations')->with('success', 'Бронь успешно удалена');
    }
}