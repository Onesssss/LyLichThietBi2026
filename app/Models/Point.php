<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';
    
    protected $fillable = [
        'name', 'code', 'department_id', 'order', 'status'
    ];
    
    // Quan hệ: Thuộc về một Department (Cung)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    
    public function branch()
    {
        return $this->hasOneThrough(Branch::class, Department::class, 
            'id', 'id', 'department_id', 'branch_id');
    }
        // Quan hệ: Có nhiều EquipmentList
    public function equipmentLists()
    {
        return $this->hasMany(EquipmentList::class, 'point_id');
    }
    }