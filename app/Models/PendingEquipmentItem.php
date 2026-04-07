<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingEquipmentItem extends Model
{
    protected $table = 'pending_equipment_items';
    
    protected $fillable = [
        'original_id', 'name', 'category_id', 'point_id',
        'material', 'unit', 'quantity', 'manufacture_year', 'expiry_date',
        'condition', 'note', 'status',
        'action_type', 'approval_status', 'requested_by', 'requested_at',
        'approved_by', 'approved_at', 'rejection_reason'
    ];
    
    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'expiry_date' => 'date',
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