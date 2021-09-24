<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'province',
        'city',
        'district',  // 区
        'address',
        'zip',  // 邮政编码
        'contact_name',
        'contact_phone',
        'last_used_at',  // 最后一次使用时间
    ];
    protected $dates = ['last_used_at'];

    public function user(){
        // 地址属于用户
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(){
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
