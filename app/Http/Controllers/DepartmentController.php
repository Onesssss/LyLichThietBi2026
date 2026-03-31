<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Branch;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        if (!PermissionHelper::canManageDepartments()) {
            abort(403, 'Bạn không có quyền truy cập');
        }
        
        $query = Department::with('branch');
        $query = PermissionHelper::filterDepartment($query);
        $departments = $query->orderBy('id', 'desc')->get();
        
        return view('departments.index', compact('departments'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        if (!PermissionHelper::canManageDepartments()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
        
        if (PermissionHelper::isAdmin() || PermissionHelper::isModerator()) {
            $branches = Branch::orderBy('name')->get();
        } else {
            $branches = Branch::where('id', PermissionHelper::getBranchId())->get();
        }
        
        return view('departments.create', compact('branches'));
    }

    // Lưu mới
    public function store(Request $request)
    {
        if (!PermissionHelper::canManageDepartments()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
        
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:100|unique:departments,name'
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Thêm cung thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        if (!PermissionHelper::canManageDepartments()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $department = Department::findOrFail($id);
        
        // Kiểm tra quyền sửa theo role
        if (PermissionHelper::isUser() && $department->branch_id != PermissionHelper::getBranchId()) {
            abort(403, 'Bạn không có quyền sửa cung này');
        }
        
        if (PermissionHelper::isGuest() && $department->id != PermissionHelper::getDeptId()) {
            abort(403, 'Bạn không có quyền sửa cung này');
        }
        
        if (PermissionHelper::isAdmin() || PermissionHelper::isModerator()) {
            $branches = Branch::orderBy('name')->get();
        } else {
            $branches = Branch::where('id', PermissionHelper::getBranchId())->get();
        }
        
        return view('departments.edit', compact('department', 'branches'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        if (!PermissionHelper::canManageDepartments()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $department = Department::findOrFail($id);
        
        if (PermissionHelper::isUser() && $department->branch_id != PermissionHelper::getBranchId()) {
            abort(403, 'Bạn không có quyền sửa cung này');
        }
        
        if (PermissionHelper::isGuest() && $department->id != PermissionHelper::getDeptId()) {
            abort(403, 'Bạn không có quyền sửa cung này');
        }
        
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:100|unique:departments,name,' . $id
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Cập nhật cung thành công!');
    }

    // Xóa
    public function destroy($id)
    {
        // Chỉ Admin và Moderator mới được xóa
        if (!PermissionHelper::canManageBranches()) {
            abort(403, 'Bạn không có quyền xóa');
        }
        
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Xóa cung thành công!');
    }
}