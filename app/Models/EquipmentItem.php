<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentItem extends Model
{
    protected $table = 'equipment_items';
    
    protected $fillable = [
    'name', 'category_id', 'point_id', 'material', 'unit',
    'quantity', 'manufacture_year', 'expiry_date', 'condition', 'note', 'status'
    ];
    
    protected $casts = [
        'expiry_date' => 'date',
        'manufacture_year' => 'integer',
        'quantity' => 'integer'
    ];
    
    // Quan hệ: Thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }
    
    // Quan hệ gián tiếp: Thiết bị thuộc về danh sách thông qua danh mục
    public function equipmentList()
    {
        return $this->hasOneThrough(EquipmentList::class, EquipmentCategory::class, 
            'id', 'id', 'category_id', 'list_id');
    }

    // Quan hệ với Point
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
}