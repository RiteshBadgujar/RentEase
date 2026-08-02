<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
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

    /**
     * Attribute casting.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'parking' => 'boolean',
    ];

    /**
     * Property belongs to a user (owner).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Property has many wishlist entries.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}