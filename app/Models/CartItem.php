<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
    ];
    public $timestamps = false; // 不自动插入时间

    public function user() {
        // 反向一对多关系
        return $this->belongsTo(User::class);
    }

    public function productSku() {
        // 反向一对多关系
        return $this->belongsTo(ProductSku::class);
    }
}
