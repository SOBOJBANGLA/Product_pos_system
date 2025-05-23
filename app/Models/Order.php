<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_code',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
