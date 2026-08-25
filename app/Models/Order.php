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
        'payment_method',
        'payment_proof',
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

    public function getDailyOrderNumberAttribute(): int
    {
        return self::whereDate('created_at', $this->created_at->toDateString())
            ->where('id', '<=', $this->id)
            ->count();
    }

    public static function isOperationalHours(): bool
    {
        $hour = now()->hour;
        return $hour >= 10 && $hour < 23;
    }

    public static function getTodayOrderCount(): int
    {
        return self::whereDate('created_at', now()->toDateString())->count();
    }
}
