<?php

namespace App\Helpers;

class PermissionHelper
{
    // ==================== KIỂM TRA ROLE ====================
    
    // Admin (role_id = 0)
    public static function isAdmin()
    {
        return session('role_id') == 0;
    }
    
    // Moderator (role_id = 1)
    public static function isModerator()
    {
        return session('role_id') == 1;
    }
    
    // User (role_id = 2)
    public static function isUser()
    {
        return session('role_id') == 2;
    }
    
    // Guest (role_id = 3)
    public static function isGuest()
    {
        return session('role_id') == 3;
    }
    
    // ==================== KIỂM TRA QUYỀN TRUY CẬP ====================
    
    // Có quyền xem tất cả dữ liệu (Admin + Moderator)
    public static function canViewAll()
    {
        return in_array(session('role_id'), [0, 1]);
    }
    
    // Có quyền quản lý user (chỉ Admin)
    public static function canManageUsers()
    {
        return session('role_id') == 0;
    }
    
    // Có quyền quản lý xí nghiệp (Admin + Moderator)
    public static function canManageBranches()
    {
        return in_array(session('role_id'), [0, 1]);
    }
    
    // Có quyền quản lý cung (Admin + Moderator + User)
    public static function canManageDepartments()
    {
        return in_array(session('role_id'), [0, 1, 2]);
    }
    
    // Có quyền quản lý chốt (Admin + Moderator + User + Guest)
    public static function canManagePoints()
    {
        return in_array(session('role_id'), [0, 1, 2, 3]);
    }
    
    // ==================== LẤY THÔNG TIN USER ====================
    
    // Lấy branch_id của user
    public static function getBranchId()
    {
        return session('branch_id');
    }
    
    // Lấy dept_id của user
    public static function getDeptId()
    {
        return session('dept_id');
    }
    
    // ==================== LỌC DỮ LIỆU ====================
    
    // Lọc dữ liệu Equipment List theo quyền
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
    
    // Lọc dữ liệu Point theo quyền
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
    
    // Lọc dữ liệu Department theo quyền
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
    
    // Lọc dữ liệu Branch theo quyền
    public static function filterBranch($query)
    {
        if (self::isAdmin() || self::isModerator()) {
            return $query;
        }
        
        if (self::isUser()) {
            return $query->where('id', self::getBranchId());
        }
        
        // Guest không được xem branch
        return $query->whereRaw('1 = 0');
    }
}