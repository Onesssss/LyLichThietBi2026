<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
        protected $fillable = ['name'];
     // Quan hệ: Một Branch có nhiều Department
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
