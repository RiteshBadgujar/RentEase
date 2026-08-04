<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'property_id',

        'tenant_id',

        'landlord_id',

        'visit_date',

        'visit_time',

        'message',

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | Default Attributes
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        'status' => 'Pending',

    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'visit_date' => 'date',

    ];

    /*
    |--------------------------------------------------------------------------
    | Property Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * Booking belongs to a Property.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Tenant Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * Booking belongs to a Tenant.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Landlord Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * Booking belongs to a Landlord.
     */
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    /**
     * Rejected bookings.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    /**
     * Completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}