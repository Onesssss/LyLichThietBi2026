<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ dashboard
     */
    public function index()
    {
        // 🔥 Lấy thông tin user từ session
        $user = [
            'id' => session('user_id'),
            'username' => session('username'),
            'email' => session('email'),
            'role_id' => session('role_id'),
            'branch_id' => session('branch_id'),
            'dept_id' => session('dept_id'),
            'full_name' => session('full_name') ?? session('username')
        ];

        // 🔥 Kiểm tra đăng nhập
        if (!$user['id']) {
            return redirect()->route('login');
        }

        // 🔥 Lấy thêm thông tin từ database (last_login)
        $userInfo = Admin::find($user['id']);
        $lastLogin = $userInfo ? $userInfo->last_login : null;

        // 🔥 Role name mapping
        $roleNames = [
            0 => 'Administrator',
            1 => 'Quản lý cấp cao',
            2 => 'Quản Lý',
            3 => 'Công nhân'
        ];

        $roleName = $roleNames[$user['role_id']] ?? 'Không xác định';

        return view('home.index', compact('user', 'roleName', 'lastLogin'));
    }
}