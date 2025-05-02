<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
    ];

    /**
     * Get the user that owns the order.    
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that is being ordered.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
