<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'title', 'message', 'type', 
        'related_id', 'related_table', 'is_read', 'created_at'
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}