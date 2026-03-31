<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentList extends Model
{
    protected $table = 'equipment_lists';
    
    protected $fillable = [
        'name', 'code', 'point_id', 'description', 'status'
    ];
    
    // Quan hệ với Point
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
    
    // Quan hệ với EquipmentCategory (một danh sách có nhiều danh mục)
    public function categories()
    {
        return $this->hasMany(EquipmentCategory::class, 'list_id');
    }
    
    // Quan hệ gián tiếp với Department thông qua Point
    public function department()
    {
        return $this->hasOneThrough(Department::class, Point::class,
            'id', 'id', 'point_id', 'department_id');
    }
    
    // Quan hệ gián tiếp với Branch thông qua Point và Department
    public function branch()
    {
        return $this->hasOneThrough(Branch::class, Point::class,
            'id', 'id', 'point_id', 'branch_id');
    }
}