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
    | Default Attributes
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        'status' => 'Available',

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
     * Property belongs to a User (Owner).
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

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the full property image URL.
     */
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/no-image.png');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope only available properties.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available');
    }

    /**
     * Scope only rented properties.
     */
    public function scopeRented($query)
    {
        return $query->where('status', 'Rented');
    }
}