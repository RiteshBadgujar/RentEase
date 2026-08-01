<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

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

    'status'

];

    protected $casts = [
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'parking' => 'boolean',
    ];

    /**
     * Property belongs to a landlord (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}