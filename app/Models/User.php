<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Property;
use App\Models\Wishlist;
use App\Models\Booking;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'name',

        'email',

        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [

        'password',

        'remember_token',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Property Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * User owns many properties.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Wishlist Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * User has many wishlist items.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Booking Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Bookings created by the user (Tenant).
     */
    public function tenantBookings()
    {
        return $this->hasMany(Booking::class, 'tenant_id');
    }

    /**
     * Bookings received by the user (Landlord).
     */
    public function landlordBookings()
    {
        return $this->hasMany(Booking::class, 'landlord_id');
    }
}