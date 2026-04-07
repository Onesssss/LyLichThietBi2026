<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Department;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index(Request $request)
    {
        if (!PermissionHelper::canManagePoints()) {
            abort(403, 'Bạn không có quyền truy cập');
        }
        
        $query = Point::with(['department.branch']);
        $query = PermissionHelper::filterPoint($query);
        
  
        $departments = Department::with('branch')->orderBy('name')->get();
        

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
   
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        

        $points = $query->paginate(15)->appends($request->query());
        
        return view('points.index', compact('points', 'departments'));
    }

    public function create()
    {
        if (!PermissionHelper::canManagePoints()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
        
        if (PermissionHelper::isAdmin() || PermissionHelper::isModerator()) {
            $departments = Department::with('branch')->orderBy('name')->get();
        } elseif (PermissionHelper::isUser()) {
            $departments = Department::where('branch_id', PermissionHelper::getBranchId())
                ->with('branch')
                ->orderBy('name')->get();
        } else {
            $departments = Department::where('id', PermissionHelper::getDeptId())
                ->with('branch')
                ->orderBy('name')->get();
        }
        
        return view('points.create', compact('departments'));
    }

    public function store(Request $request)
    {
        if (!PermissionHelper::canManagePoints()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
        
        $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:points,code',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:0,1'
        ], [
            'name.required' => 'Tên chốt không được để trống',
            'code.required' => 'Mã chốt không được để trống',
            'code.unique' => 'Mã chốt đã tồn tại',
            'department_id.required' => 'Vui lòng chọn cung'
        ]);

        Point::create([
            'name' => $request->name,
            'code' => $request->code,
            'department_id' => $request->department_id,
            'order' => 1,
            'status' => $request->status
        ]);

        return redirect()->route('points.index')
            ->with('success', 'Thêm chốt thành công!');
    }

  public function edit($id)
    {
        if (!PermissionHelper::canManagePoints()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $point = Point::findOrFail($id);
        
        // Kiểm tra quyền sửa theo role
        if (PermissionHelper::isUser()) {
            $allowedDeptIds = Department::where('branch_id', PermissionHelper::getBranchId())->pluck('id')->toArray();
            if (!in_array($point->department_id, $allowedDeptIds)) {
                abort(403, 'Bạn không có quyền sửa chốt này');
            }
        }
        
        if (PermissionHelper::isGuest() && $point->department_id != PermissionHelper::getDeptId()) {
            abort(403, 'Bạn không có quyền sửa chốt này');
        }
        
        if (PermissionHelper::isAdmin() || PermissionHelper::isModerator()) {
            $departments = Department::with('branch')->orderBy('name')->get();
        } elseif (PermissionHelper::isUser()) {
            $departments = Department::where('branch_id', PermissionHelper::getBranchId())
                ->with('branch')
                ->orderBy('name')->get();
        } else {
            $departments = Department::where('id', PermissionHelper::getDeptId())
                ->with('branch')
                ->orderBy('name')->get();
        }
        
        return view('points.edit', compact('point', 'departments'));
    }

 public function update(Request $request, $id)
    {
        if (!PermissionHelper::canManagePoints()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $point = Point::findOrFail($id);
        
        if (PermissionHelper::isUser()) {
            $allowedDeptIds = Department::where('branch_id', PermissionHelper::getBranchId())->pluck('id')->toArray();
            if (!in_array($point->department_id, $allowedDeptIds)) {
                abort(403, 'Bạn không có quyền sửa chốt này');
            }
        }
        
        if (PermissionHelper::isGuest() && $point->department_id != PermissionHelper::getDeptId()) {
            abort(403, 'Bạn không có quyền sửa chốt này');
        }
        
        $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:points,code,' . $id,
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:0,1'
        ]);

        $point->update([
            'name' => $request->name,
            'code' => $request->code,
            'department_id' => $request->department_id,
            'order' => 1,
            'status' => $request->status
        ]);

        return redirect()->route('points.index')
            ->with('success', 'Cập nhật chốt thành công!');
    }

    public function destroy($id)
    {
        if (!PermissionHelper::isAdmin()) {
            abort(403, 'Chỉ Admin mới có quyền xóa');
        }
        $point = Point::findOrFail($id);
        $point->delete();

        return redirect()->route('points.index')
            ->with('success', 'Xóa chốt thành công!');
    }
}