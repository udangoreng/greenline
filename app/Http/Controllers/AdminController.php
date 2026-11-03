<?php

namespace App\Http\Controllers;

use App\Models\{Order, OrderItem, Product};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }
    public function login(Request $r)
    {
        $pw = (string) config('services.admin.password');
        if ($pw !== '' && hash_equals($pw, (string) $r->password)) {
            $r->session()->regenerate();
            session(['admin' => true]);
            return redirect('/admin');
        }
        return back()->withErrors(['password' => 'Password salah.']);
    }
    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $paid = fn($q) => $q->where('status', 'paid');
        return view('admin.dashboard', [
            'revenue' => Order::where('status', 'paid')->sum('total'),
            'paid' => Order::where('status', 'paid')->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'trees' => OrderItem::whereHas('order', $paid)->sum('qty'),
            'co2' => DB::table('order_items')->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'products.id', '=', 'order_items.product_id')->where('orders.status', 'paid')
                ->sum(DB::raw('order_items.qty * products.co2')),
            'low' => Product::where('stock', '<=', 10)->orderBy('stock')->get(),
            'orders' => Order::latest()->take(15)->get(),
        ]);
    }
    public function products(Request $r)
    {
        $p = Product::query()->when($r->q, fn($q, $s) => $q->where('name', 'like', "%$s%")->orWhere('latin', 'like', "%$s%"))
            ->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.products', ['products' => $p]);
    }
    public function orders(Request $r)
    {
        $o = Order::query()
            ->when($r->q, fn($q, $s) => $q->where(fn($w) => $w->where('code', 'like', "%$s%")->orWhere('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")))
            ->when($r->s, fn($q, $s) => match ($s) {
                'pending', 'failed' => $q->where('status', $s),
                'paid' => $q->where('status', 'paid')->whereNull('stage'),
                'processing', 'shipped', 'done' => $q->where('stage', $s),
                default => $q,
            })->latest()->paginate(15)->withQueryString();
        return view('admin.orders', ['orders' => $o]);
    }
    public function form(?Product $product = null)
    {
        return view('admin.form', ['p' => $product ?? new Product(['emoji' => '🌱', 'sdg' => 15, 'stock' => 100])]);
    }
    public function save(Request $r, ?Product $product = null)
    {
        $v = $r->validate([
            'name' => 'required|max:100',
            'latin' => 'required|max:100',
            'type' => 'required|max:30',
            'price' => 'required|integer|min:1000',
            'co2' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);
        unset($v['image']);
        if ($r->hasFile('image')) {
            if ($product?->image) Storage::disk('public')->delete($product->image);
            $v['image'] = $r->file('image')->store('products', 'public');
        }
        $product ? $product->update($v) : Product::create($v);
        return redirect('/admin/produk');
    }
    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (QueryException $e) {
            return back()->withErrors(['x' => 'Produk sudah pernah dipesan; set stok ke 0 saja.']);
        }
        return redirect('/admin/produk');
    }
    public function order(Order $order)
    {
        return view('admin.order', compact('order'));
    }
    public function updateOrder(Request $r, Order $order)
    {
        $v = $r->validate(['stage' => 'nullable|in:processing,shipped', 'tracking_no' => 'nullable|max:60']);
        if ($order->status !== 'paid') return back()->withErrors(['stage' => 'Hanya pesanan lunas yang bisa diperbarui.']);
        if ($order->stage === 'done') return back()->withErrors(['stage' => 'Pesanan sudah dikonfirmasi selesai oleh pembeli.']);
        $order->update(['stage' => $v['stage'] ?? null, 'tracking_no' => $v['tracking_no'] ?? null]);
        return back();
    }
}
