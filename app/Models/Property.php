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
        'balconies' => 0,
        'parking' => false,
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'area' => 'decimal:2',

        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'balconies' => 'integer',

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
     *
     * Images are stored on Laravel's public storage disk.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }

        return asset('storage/' . $this->image);
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
        return $query->where(
            'status',
            'Available'
        );
    }


    /**
     * Scope only rented properties.
     */
    public function scopeRented($query)
    {
        return $query->where(
            'status',
            'Rented'
        );
    }


    /**
     * Scope only pending properties.
     */
    public function scopePending($query)
    {
        return $query->where(
            'status',
            'Pending'
        );
    }
}