<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $table = 'approval_histories';
    public $timestamps = false;
    
    protected $fillable = [
        'pending_table', 'pending_id', 'action_type', 
        'action_result', 'approved_by', 'approved_at', 'rejection_reason'
    ];
    
    protected $casts = [
        'approved_at' => 'datetime',
    ];
    
    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }
}