<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InternalException;

class ProductSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'stock',
    ];

    // 与商品关联
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function decreaseStock($amount) {
        if ($amount < 0) {
            throw new InternalException('减库存不可小于0');
        }
        // 避免超卖问题
        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount) {
        if ($amount < 0) {
            throw new InternalException('加库存不可小于0');
        }
        // increment 保证操作的原子性
        $this->increment('stock', $amount);
    }
}
