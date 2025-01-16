<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'photo',
        'username',
        'password',
        'number',
        'city',
        'state',
        'address',
        'country',
        'billing_fname',
        'billing_lname',
        'billing_email',
        'billing_photo',
        'billing_number',
        'billing_city',
        'billing_state',
        'billing_address',
        'billing_country',
        'shpping_fname',
        'shpping_lname',
        'shpping_email',
        'shpping_photo',
        'shpping_number',
        'shpping_city',
        'shpping_state',
        'shpping_address',
        'shpping_country',
        'status',
        'verification_link',
        'email_verified',
        'billing_country_code',
        'shipping_country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\ProductOrder');
    }

    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function product_reviews()
    {
        return $this->hasMany('App\Models\ProductReview');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class , 'user_offer');
    }
    public function favourites(){

        return $this->hasMany(Favourite::class,'user_id','id');

    }

    public function carts()
    {
        return $this->hasMany(Cart::class , 'user_id' , 'id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
