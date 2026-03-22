<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetRequest extends Model
{
    protected $table = 'password_reset_requests';
    
    protected $fillable = [
        'email', 
        'full_name', 
        'status', 
        'requested_at', 
        'processed_at', 
        'processed_by'
    ];
    
    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];
    // Quan hệ với Admin (người xử lý)
    public function processor()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }
}