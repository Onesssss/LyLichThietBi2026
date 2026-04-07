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
    
    public $timestamps = false;
    
    // Quan hệ với Admin đã xử lý
    public function processor()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }
    

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }
    

    public function scopeProcessed($query)
    {
        return $query->where('status', 1);
    }

    public function isExpired()
    {
        if ($this->status == 1 && $this->processed_at) {
            $expireTime = strtotime($this->processed_at) + 120; 
            return time() > $expireTime;
        }
        return false;
    }
}