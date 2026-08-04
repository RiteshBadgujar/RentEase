<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Property;
use App\Models\Wishlist;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Enquiry;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'name',

        'email',

        'role',

        'password',

    ];

    /*
    |--------------------------------------------------------------------------
    | Hidden Attributes
    |--------------------------------------------------------------------------
    */

    protected $hidden = [

        'password',

        'remember_token',

    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
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
    | Role Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is Admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Landlord.
     */
    public function isLandlord()
    {
        return $this->role === 'landlord';
    }

    /**
     * Check if user is Tenant.
     */
    public function isTenant()
    {
        return $this->role === 'tenant';
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }

    public function scopeTenants($query)
    {
        return $query->where('role', 'tenant');
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

    /*
    |--------------------------------------------------------------------------
    | Enquiry Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Enquiries sent by the user.
     */
    public function sentEnquiries()
    {
        return $this->hasMany(Enquiry::class, 'sender_id');
    }

    /**
     * Enquiries received by the user.
     */
    public function receivedEnquiries()
    {
        return $this->hasMany(Enquiry::class, 'receiver_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Notification Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * User has many notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}