<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [

        'property_id',

        'sender_id',

        'receiver_id',

        'message',

        'status'

    ];

    /**
     * Enquiry belongs to a Property.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * User who sent the enquiry.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Property owner who received the enquiry.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}