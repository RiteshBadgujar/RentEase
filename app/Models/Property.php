<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'user_id',

        'title',

        'slug',

        'description',

        'property_type',

        'purpose',

        'price',

        'deposit',

        'bedrooms',

        'bathrooms',

        'balconies',

        'area',

        'furnishing',

        'parking',

        'address',

        'city',

        'state',

        'pincode',

        'image',

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'price' => 'decimal:2',

        'deposit' => 'decimal:2',

        'parking' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Property belongs to a User (Owner)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Property has many Wishlist items.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Property has many Enquiries.
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Property has many Bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}