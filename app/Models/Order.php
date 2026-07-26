<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'notes',
        'total_price',
        'status',
        'is_read',
    ];

    protected $casts = [
        'total_price' => 'integer',
        'is_read' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(fn($item) => $item->price * $item->quantity);
    }
}
