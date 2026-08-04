<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'user_id',

        'module',

        'action',

        'description',

        'ip_address',

        'browser',

    ];

    /**
     * Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}