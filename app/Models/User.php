<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    /**
     * Check if user is Landlord.
     */
    public function isLandlord(): bool
    {
        return $this->role === 'landlord';
    }


    /**
     * Check if user is Tenant.
     */
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }


    /**
     * Scope landlord users.
     */
    public function scopeLandlords($query)
    {
        return $query->where('role', 'landlord');
    }


    /**
     * Scope tenant users.
     */
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
     * Bookings created by the user as Tenant.
     */
    public function tenantBookings()
    {
        return $this->hasMany(
            Booking::class,
            'tenant_id'
        );
    }


    /**
     * Bookings received by the user as Landlord.
     */
    public function landlordBookings()
    {
        return $this->hasMany(
            Booking::class,
            'landlord_id'
        );
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
        return $this->hasMany(
            Enquiry::class,
            'sender_id'
        );
    }


    /**
     * Enquiries received by the user.
     */
    public function receivedEnquiries()
    {
        return $this->hasMany(
            Enquiry::class,
            'receiver_id'
        );
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
        return $this->hasMany(
            Notification::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Activity Log Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * User has many activity logs.
     */
    public function activityLogs()
    {
        return $this->hasMany(
            ActivityLog::class
        );
    }
}