<?php

namespace App\Http\Controllers;

use App\Models\PendingEquipmentCategory;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\EquipmentCategory;
use App\Models\EquipmentList;
use App\Models\Point;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = EquipmentCategory::with(['equipmentList', 'point.department.branch']);
        

        $query = PermissionHelper::filterEquipmentList($query, 'list_id');

        $listsForFilter = EquipmentList::with(['point.department.branch'])
            ->orderBy('point_id')
            ->orderBy('name')
            ->get()
            ->map(function($list) {
                $list->display_name = '[' . ($list->point->department->branch->name ?? '') . ' - ' . 
                                            ($list->point->department->name ?? '') . ' - ' . 
                                            ($list->point->name ?? '') . '] ' . $list->name;
                return $list;
            });

        $pointsQuery = Point::with(['department.branch']);
        $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        $points = $pointsQuery->orderBy('name')->get();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
 
        if ($request->filled('list_id')) {
            $query->where('list_id', $request->list_id);
        }

        if ($request->filled('point_id')) {
            $query->where('point_id', $request->point_id);
        }
     
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
  
        $categories = $query->paginate(15)->appends($request->query());
        
        return view('equipment-categories.index', compact('categories', 'points', 'listsForFilter'));
    }

    public function create()
    {
   
        $listsQuery = EquipmentList::with(['point.department.branch']);

        if (PermissionHelper::isGuest()) {
            $listsQuery->whereHas('point', function($q) {
                $q->where('department_id', PermissionHelper::getDeptId());
            });
        } else {
           
            $listsQuery = PermissionHelper::filterEquipmentList($listsQuery);
        }
        $lists = $listsQuery->orderBy('name')->get();
        
       
        $pointsQuery = Point::with(['department.branch']);
        
       
        if (PermissionHelper::isGuest()) {
            $pointsQuery->where('department_id', PermissionHelper::getDeptId());
        } else {
        
            $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        }
        $points = $pointsQuery->orderBy('name')->get();
        
        return view('equipment-categories.create', compact('lists', 'points'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'list_id' => 'required|exists:equipment_lists,id',
            'point_id' => 'required|exists:points,id',
            'status' => 'required|in:0,1'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'list_id.required' => 'Vui lòng chọn danh sách thiết bị',
            'point_id.required' => 'Vui lòng chọn chốt'
        ]);

        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentCategory::create([
                'name' => $request->name,
                'list_id' => $request->list_id,
                'point_id' => $request->point_id,
                'status' => $request->status,
                'action_type' => 'create',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_categories', 'create');
            
            return redirect()->route('equipment-categories.index')
                ->with('success', 'Yêu cầu thêm danh mục thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
       
        EquipmentCategory::create([
            'name' => $request->name,
            'list_id' => $request->list_id,
            'point_id' => $request->point_id,
            'status' => $request->status
        ]);

        return redirect()->route('equipment-categories.index')
            ->with('success', 'Thêm danh mục thiết bị thành công!');
    }

    public function edit($id)
    {
        $category = EquipmentCategory::findOrFail($id);
        
   
        if (PermissionHelper::isGuest()) {
            $allowedPoints = Point::where('department_id', PermissionHelper::getDeptId())->pluck('id')->toArray();
            if (!in_array($category->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        } elseif (!PermissionHelper::canViewAll() && !PermissionHelper::isUser()) {
            $allowedLists = PermissionHelper::filterEquipmentList(EquipmentList::query())->pluck('id')->toArray();
            if (!in_array($category->list_id, $allowedLists)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
       
        $listsQuery = EquipmentList::with(['point.department.branch']);
        
        if (PermissionHelper::isGuest()) {
            $listsQuery->whereHas('point', function($q) {
                $q->where('department_id', PermissionHelper::getDeptId());
            });
        } else {
            $listsQuery = PermissionHelper::filterEquipmentList($listsQuery);
        }
        $lists = $listsQuery->orderBy('name')->get();
        
    
        $pointsQuery = Point::with(['department.branch']);
        
        if (PermissionHelper::isGuest()) {
            $pointsQuery->where('department_id', PermissionHelper::getDeptId());
        } else {
            $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        }
        $points = $pointsQuery->orderBy('name')->get();
        
        return view('equipment-categories.edit', compact('category', 'lists', 'points'));
    }

    public function update(Request $request, $id)
    {
        $category = EquipmentCategory::findOrFail($id);
        
       
        if (!PermissionHelper::canViewAll()) {
            $allowedLists = PermissionHelper::filterEquipmentList(EquipmentList::query())->pluck('id')->toArray();
            if (!in_array($category->list_id, $allowedLists)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
        $request->validate([
            'name' => 'required|string|max:200',
            'list_id' => 'required|exists:equipment_lists,id',
            'point_id' => 'required|exists:points,id',
            'status' => 'required|in:0,1'
        ]);
        
   
        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentCategory::create([
                'original_id' => $id,
                'name' => $request->name,
                'list_id' => $request->list_id,
                'point_id' => $request->point_id,
                'status' => $request->status,
                'action_type' => 'update',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_categories', 'update');
            
            return redirect()->route('equipment-categories.index')
                ->with('success', 'Yêu cầu cập nhật danh mục thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
      
        $category->update([
            'name' => $request->name,
            'list_id' => $request->list_id,
            'point_id' => $request->point_id,
            'status' => $request->status
        ]);
        
        return redirect()->route('equipment-categories.index')
            ->with('success', 'Cập nhật danh mục thiết bị thành công!');
    }

    public function destroy($id)
    {
        $category = EquipmentCategory::findOrFail($id);
        
  
        if (!PermissionHelper::canViewAll()) {
            $allowedLists = PermissionHelper::filterEquipmentList(EquipmentList::query())->pluck('id')->toArray();
            if (!in_array($category->list_id, $allowedLists)) {
                abort(403, 'Bạn không có quyền xóa dữ liệu này');
            }
        }
        
   
        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentCategory::create([
                'original_id' => $id,
                'name' => $category->name,
                'list_id' => $category->list_id,
                'point_id' => $category->point_id,
                'status' => $category->status,
                'action_type' => 'delete',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_categories', 'delete');
            
            return redirect()->route('equipment-categories.index')
                ->with('success', 'Yêu cầu xóa danh mục thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        

        $category->delete();
        
        return redirect()->route('equipment-categories.index')
            ->with('success', 'Xóa danh mục thiết bị thành công!');
    }

    private function sendApprovalNotification($pendingId, $table, $action)
    {
        $admins = Admin::whereIn('role_id', [0, 1])->get();
        
        $actionText = [
            'create' => 'thêm mới',
            'update' => 'cập nhật',
            'delete' => 'xóa'
        ];
        
        $tableText = [
            'equipment_categories' => 'danh mục thiết bị'
        ];
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Yêu cầu duyệt mới',
                'message' => 'Có yêu cầu ' . $actionText[$action] . ' ' . $tableText[$table] . '. Vui lòng kiểm tra.',
                'type' => 'approval_request',
                'related_id' => $pendingId,
                'related_table' => $table,
                'is_read' => false,
                'created_at' => now(),
            ]);
        }
    }
}