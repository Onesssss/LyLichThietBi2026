<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingEquipmentCategory extends Model
{
    protected $table = 'pending_equipment_categories';
    
    protected $fillable = [
        'original_id', 'name', 'list_id', 'point_id', 'status',
        'action_type', 'approval_status', 'requested_by', 'requested_at',
        'approved_by', 'approved_at', 'rejection_reason'
    ];
    
    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
    ];
    
    public function requester()
    {
        return $this->belongsTo(Admin::class, 'requested_by');
    }
    
    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }
}