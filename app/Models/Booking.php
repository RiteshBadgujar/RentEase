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
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Booking belongs to a Property.
     */
    public function property()
    {
        return $this->belongsTo(
            Property::class,
            'property_id'
        );
    }


    /**
     * Booking belongs to a Tenant.
     */
    public function tenant()
    {
        return $this->belongsTo(
            User::class,
            'tenant_id'
        );
    }


    /**
     * Booking belongs to a Landlord.
     */
    public function landlord()
    {
        return $this->belongsTo(
            User::class,
            'landlord_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where(
            'status',
            'Pending'
        );
    }


    /**
     * Scope approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where(
            'status',
            'Approved'
        );
    }


    /**
     * Scope rejected bookings.
     */
    public function scopeRejected($query)
    {
        return $query->where(
            'status',
            'Rejected'
        );
    }


    /**
     * Scope completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where(
            'status',
            'Completed'
        );
    }
}