<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins'; 
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'username', 'password', 'email', 'full_name', 'role_id', 
        'branch_id', 'dept_id', 'status'
    ];
        protected $dates = ['last_login'];
    
  // Quan hệ với Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    
    // Quan hệ với Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}