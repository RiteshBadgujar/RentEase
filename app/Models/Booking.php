<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'property_id',

        'tenant_id',

        'landlord_id',

        'visit_date',

        'visit_time',

        'message',

        'status'

    ];

    /*
    |--------------------------------------------------------------------------
    | Property Relationship
    |--------------------------------------------------------------------------
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

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Landlord Relationship
    |--------------------------------------------------------------------------
    */

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}