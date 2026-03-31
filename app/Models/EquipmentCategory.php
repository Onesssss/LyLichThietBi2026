<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    protected $table = 'equipment_categories';
    
    protected $fillable = [
          'name', 'code', 'list_id', 'point_id', 'description', 'status' 
    ];
    
    // Quan hệ: Thuộc về một danh sách thiết bị
    public function equipmentList()
    {
        return $this->belongsTo(EquipmentList::class, 'list_id');
    }
    // Quan hệ: Có nhiều thiết bị
    public function items()
    {
        return $this->hasMany(EquipmentItem::class, 'category_id');
    }
    // Quan hệ với Point
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
}