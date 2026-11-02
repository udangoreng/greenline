<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    public const STEPS = ['paid' => 'Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'done' => 'Selesai'];
    protected $guarded = [];
    public function items() { return $this->hasMany(OrderItem::class); }
    public function getRouteKeyName() { return 'code'; }
    public function getLabelAttribute() {
        return match (true) {
            $this->status === 'failed' => 'Gagal/Kedaluwarsa',
            $this->status === 'pending' => 'Menunggu pembayaran',
            default => self::STEPS[$this->stage ?? 'paid'],
        };
    }
}
