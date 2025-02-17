<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'language_id',
        'description',
        'status',
        'image',
        'price',
        'start_date',
        'end_date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_offer');
    }

}
