<?php

namespace App\Helpers;

class PermissionHelper
{

    

    public static function isAdmin()
    {
        return session('role_id') == 0;
    }
    
    public static function isModerator()
    {
        return session('role_id') == 1;
    }

    public static function isUser()
    {
        return session('role_id') == 2;
    }
    

    public static function isGuest()
    {
        return session('role_id') == 3;
    }
    
    public static function canViewAll()
    {
        return in_array(session('role_id'), [0, 1]);
    }
    

    public static function canManageUsers()
    {
        return in_array(session('role_id'), [0, 1]);

    }
    

    public static function canManageBranches()
    {
        return in_array(session('role_id'), [0, 1]);
    }
    

    public static function canManageDepartments()
    {
        return in_array(session('role_id'), [0, 1, 2]);
    }
    

    public static function canManagePoints()
    {
        return in_array(session('role_id'), [0, 1, 2, 3]);
    }
    

    

    public static function getBranchId()
    {
        return session('branch_id');
    }
    

    public static function getDeptId()
    {
        return session('dept_id');
    }
    


    public static function filterEquipmentList($query, $relationColumn = 'point_id')
    {
        if (self::isAdmin() || self::isModerator()) {
            return $query;
        }
        
        if (self::isUser()) {
            return $query->whereHas('point.department.branch', function($q) {
                $q->where('id', self::getBranchId());
            });
        }
        
        if (self::isGuest()) {
            return $query->whereHas('point.department', function($q) {
                $q->where('id', self::getDeptId());
            });
        }
        
        return $query;
    }
    

    public static function filterPoint($query)
    {
        if (self::isAdmin() || self::isModerator()) {
            return $query;
        }
        
        if (self::isUser()) {
            return $query->whereHas('department.branch', function($q) {
                $q->where('id', self::getBranchId());
            });
        }
        
        if (self::isGuest()) {
            return $query->where('department_id', self::getDeptId());
        }
        
        return $query;
    }
    

    public static function filterDepartment($query)
    {
        if (self::isAdmin() || self::isModerator()) {
            return $query;
        }
        
        if (self::isUser()) {
            return $query->where('branch_id', self::getBranchId());
        }
        
        if (self::isGuest()) {
            return $query->where('id', self::getDeptId());
        }
        
        return $query;
    }

    public static function filterBranch($query)
    {
        if (self::isAdmin() || self::isModerator()) {
            return $query;
        }
        
        if (self::isUser()) {
            return $query->where('id', self::getBranchId());
        }
        

        return $query->whereRaw('1 = 0');
    }
}