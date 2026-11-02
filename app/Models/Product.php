<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $guarded = [];
    public function getPhotoAttribute() { return $this->image ? asset('storage/' . $this->image) : null; }
}
