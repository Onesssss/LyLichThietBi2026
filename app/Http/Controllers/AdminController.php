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
public function index(Request $request)
{

    if (!PermissionHelper::canManageUsers()) {
        abort(403, 'Chỉ Admin mới có quyền truy cập');
    }
    

    $query = Admin::with(['branch', 'department']);
    

    if (session('role_id') != 0) {
        $query->where('role_id', '!=', 0);
    }
    

    $branches = Branch::orderBy('name')->get();
    

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('username', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }
    

    if ($request->filled('role_id')) {
        $query->where('role_id', $request->role_id);
    }

    if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
    }
    
  
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
   
    $sortBy = $request->get('sort_by', 'id');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    

    $admins = $query->paginate(15)->appends($request->query());
    
    return view('admins.index', compact('admins', 'branches'));
}


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


    public function edit($id)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền sửa');
        }
        
        $admin = Admin::findOrFail($id);
        
        if ($admin->role_id == 0 && $admin->id != session('user_id')) {
            abort(403, 'Bạn không thể sửa tài khoản Admin khác');
        }
        
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get();
        
        return view('admins.edit', compact('admin', 'branches', 'departments'));
    }


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

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = $request->password;
        }

        $admin->update($data);

        return redirect()->route('admins.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        if (!PermissionHelper::canManageUsers()) {
            abort(403, 'Chỉ Admin mới có quyền xóa');
        }
        
        $admin = Admin::findOrFail($id);
        
        if ($admin->id == session('user_id')) {
            return redirect()->route('admins.index')
                ->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }
        
        if ($admin->role_id == 0) {
            return redirect()->route('admins.index')
                ->with('error', 'Bạn không thể xóa tài khoản Admin!');
        }
        
        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}