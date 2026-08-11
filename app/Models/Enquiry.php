<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'property_id',
        'sender_id',
        'receiver_id',
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
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Enquiry belongs to a Property.
     */
    public function property()
    {
        return $this->belongsTo(
            Property::class,
            'property_id'
        );
    }


    /**
     * User who sent the enquiry.
     */
    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }


    /**
     * Property owner who received the enquiry.
     */
    public function receiver()
    {
        return $this->belongsTo(
            User::class,
            'receiver_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope pending enquiries.
     */
    public function scopePending($query)
    {
        return $query->where(
            'status',
            'Pending'
        );
    }


    /**
     * Scope replied enquiries.
     */
    public function scopeReplied($query)
    {
        return $query->where(
            'status',
            'Replied'
        );
    }


    /**
     * Scope closed enquiries.
     */
    public function scopeClosed($query)
    {
        return $query->where(
            'status',
            'Closed'
        );
    }
}