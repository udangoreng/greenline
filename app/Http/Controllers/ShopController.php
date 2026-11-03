<?php

namespace App\Http\Controllers;

use App\Models\{Order, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\{Config, Snap, Transaction};

class ShopController extends Controller
{
    private function midtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    public static function map(string $s): string
    {
        return match ($s) {
            'settlement', 'capture' => 'paid',
            'deny', 'cancel', 'expire', 'failure' => 'failed',
            default => 'pending'
        };
    }

    public static function setStatus(Order $order, string $s): void
    {
        DB::transaction(function () use ($order, $s) {
            $o = Order::lockForUpdate()->find($order->id);
            if ($o->status === 'paid' || $o->status === $s) return;
            if ($s === 'paid') foreach ($o->items as $i) {
                $q = (int) $i->qty;
                Product::where('id', $i->product_id)->update(['stock' => DB::raw("CASE WHEN stock > $q THEN stock - $q ELSE 0 END")]);
            }
            $o->update(['status' => $s]);
        });
    }
    public function home()
    {
        return view('home', ['featured' => Product::inRandomOrder()->take(4)->get()]);
    }
    public function index(Request $r)
    {
        $q = Product::query()->when($r->t, fn($q, $t) => $q->where('type', $t));
        return view('catalog', ['products' => $q->orderBy('id')->paginate(12)->withQueryString(), 'types' => Product::distinct()->pluck('type')]);
    }
    public function show(Product $product)
    {
        return view('show', compact('product'));
    }

    public function cart()
    {
        $c = session('cart', []);
        return view('cart', ['c' => $c, 'items' => Product::whereIn('id', array_keys($c))->get()]);
    }
    public function add(Request $r, Product $product)
    {
        if ($product->stock < 1) return back();
        $c = session('cart', []);
        $c[$product->id] = min($product->stock, ($c[$product->id] ?? 0) + max(1, (int) $r->qty));
        session(['cart' => $c]);
        return redirect('/keranjang');
    }
    public function update(Request $r)
    {
        session(['cart' => collect($r->qty ?? [])->map(fn($n) => (int) $n)->filter(fn($n) => $n > 0)->all()]);
        return redirect('/keranjang');
    }
    public function checkout()
    {
        $c = session('cart', []);
        if (!$c) return redirect('/produk');
        return view('checkout', ['c' => $c, 'items' => Product::whereIn('id', array_keys($c))->get()]);
    }
    public function store(Request $r)
    {
        $v = $r->validate(['name' => 'required|max:100', 'email' => 'required|email', 'phone' => 'required|max:20', 'address' => 'required', 'zone' => 'required|in:' . implode(',', array_keys(config('shop.zones')))]);
        $c = session('cart', []);
        if (!$c) return redirect('/produk');
        $order = DB::transaction(function () use ($v, $c) {
            $products = Product::whereIn('id', array_keys($c))->get();
            $sub = $products->sum(fn($p) => $p->price * $c[$p->id]); // harga dari DB, bukan dari klien
            $ship = (int) config("shop.zones.{$v['zone']}.rate") * max(1, (int) array_sum($c));
            $o = Order::create($v + ['code' => 'HB-' . now()->format('ymdHis') . rand(10, 99), 'shipping' => $ship, 'total' => $sub + $ship, 'user_id' => auth()->id()]);
            foreach ($products as $p) $o->items()->create(['product_id' => $p->id, 'name' => $p->name, 'price' => $p->price, 'qty' => $c[$p->id]]);
            return $o;
        });
        $this->midtrans();
        $order->update(['snap_token' => Snap::getSnapToken([
            'transaction_details' => ['order_id' => $order->code, 'gross_amount' => $order->total],
            'item_details' => $order->items->map(fn($i) => ['id' => $i->product_id, 'price' => $i->price, 'quantity' => $i->qty, 'name' => substr($i->name, 0, 50)])->when($order->shipping > 0, fn($c) => $c->push(['id' => 'ONGKIR', 'price' => $order->shipping, 'quantity' => 1, 'name' => 'Ongkos kirim']))->all(),
            'customer_details' => ['first_name' => $order->name, 'email' => $order->email, 'phone' => $order->phone],
        ])]);
        session()->forget('cart');
        return redirect("/pesanan/{$order->code}");
    }
    public function orders(Request $r)
    {
        $uid = auth()->id();
        $q = Order::with('items')->where('user_id', $uid)
            ->when(in_array($r->s, ['pending', 'paid', 'failed']), fn($q) => $q->where('status', $r->s))->latest();
        $paid = DB::table('order_items')->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', $uid)->where('orders.status', 'paid');
        return view('orders', [
            'orders' => $q->paginate(10)->withQueryString(),
            'spent' => Order::where('user_id', $uid)->where('status', 'paid')->sum('total'),
            'trees' => (clone $paid)->sum('order_items.qty'),
            'co2' => $paid->sum(DB::raw('order_items.qty * products.co2')),
        ]);
    }

    public function confirm(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 404);
        if ($order->status === 'paid' && $order->stage === 'shipped') {
            $order->update(['stage' => 'done']);
            return back()->with('ok', 'Terima kasih! Pesanan ditandai selesai. 🌱');
        }
        return back();
    }
    public function order(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 404); // hanya pemilik pesanan
        if ($order->status === 'pending') { // sinkron status (berguna saat lokal tanpa webhook)
            try {
                $this->midtrans();
                $st = (object) Transaction::status($order->code);
                self::setStatus($order, self::map($st->transaction_status));
                $order->refresh();
            } catch (\Throwable $e) {
            }
        }
        return view('order', compact('order'));
    }
    public function notify()
    {
        $this->midtrans();
        $n = new \Midtrans\Notification(); // data diverifikasi langsung ke Midtrans
        if ($o = Order::where('code', $n->order_id)->first()) self::setStatus($o, self::map($n->transaction_status));
        return response('OK');
    }
}
