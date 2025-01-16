<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'title',
        'variations',
        'addons',
        'variations_price',
        'addons_price',
        'product_price',
        'total',
        'qty',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
