<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'url',
        'is_read',
    ];


    /*
    |--------------------------------------------------------------------------
    | Default Attributes
    |--------------------------------------------------------------------------
    */

    protected $attributes = [
        'is_read' => false,
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'is_read' => 'boolean',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Notification belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where(
            'is_read',
            false
        );
    }


    /**
     * Scope read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where(
            'is_read',
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {

            $this->update([
                'is_read' => true,
            ]);
        }
    }


    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): void
    {
        if ($this->is_read) {

            $this->update([
                'is_read' => false,
            ]);
        }
    }
}