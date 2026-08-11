<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [

        'website_name',

        'logo',

        'favicon',

        'contact_email',

        'contact_phone',

        'address',

        'footer_text',

        'facebook',

        'instagram',

        'linkedin',

        'twitter',

    ];
}