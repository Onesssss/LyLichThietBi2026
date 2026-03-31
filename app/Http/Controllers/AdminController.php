<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Point;
use App\Helpers\PermissionHelper; 
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Hiển thị danh sách admin
    public function index()
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền truy cập');
        }
        
        $admins = Admin::with(['branch', 'department'])->orderBy('id', 'desc')->get();
        return view('admins.index', compact('admins'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền thêm mới');
        }
        
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get();
        
        return view('admins.create', compact('branches', 'departments'));
    }

    // Lưu admin mới
    public function store(Request $request)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền thêm mới');
        }
        
        $request->validate([
            'username' => 'required|string|max:50|unique:admins,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:admins,email',
            'full_name' => 'required|string|max:100',
            'role_id' => 'required|in:0,1,2,3',
            'branch_id' => 'nullable|exists:branches,id',
            'dept_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:0,1'
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'dept_id' => $request->dept_id,
            'status' => $request->status
        ]);

        return redirect()->route('admins.index')
            ->with('success', 'Thêm người dùng thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền sửa');
        }
        
        $admin = Admin::findOrFail($id);
        
        // Không cho sửa Admin khác nếu không phải là chính mình
        if ($admin->role_id == 0 && $admin->id != session('user_id')) {
            abort(403, 'Bạn không thể sửa tài khoản Admin khác');
        }
        
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get();
        
        return view('admins.edit', compact('admin', 'branches', 'departments'));
    }

    // Cập nhật admin
    public function update(Request $request, $id)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền sửa');
        }
        
        $admin = Admin::findOrFail($id);
        
        if ($admin->role_id == 0 && $admin->id != session('user_id')) {
            abort(403, 'Bạn không thể sửa tài khoản Admin khác');
        }
        
        $request->validate([
            'username' => 'required|string|max:50|unique:admins,username,' . $id,
            'email' => 'required|email|unique:admins,email,' . $id,
            'full_name' => 'required|string|max:100',
            'role_id' => 'required|in:0,1,2,3',
            'branch_id' => 'nullable|exists:branches,id',
            'dept_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:0,1'
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'dept_id' => $request->dept_id,
            'status' => $request->status
        ];

        // Nếu có nhập mật khẩu mới thì cập nhật
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = $request->password;
        }

        $admin->update($data);

        return redirect()->route('admins.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    // Xóa admin
    public function destroy($id)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền xóa');
        }
        
        $admin = Admin::findOrFail($id);
        
        // Không cho xóa chính mình
        if ($admin->id == session('user_id')) {
            return redirect()->route('admins.index')
                ->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }
        
        // Không cho xóa Admin khác
        if ($admin->role_id == 0) {
            return redirect()->route('admins.index')
                ->with('error', 'Bạn không thể xóa tài khoản Admin!');
        }
        
        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}