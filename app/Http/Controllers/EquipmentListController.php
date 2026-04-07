<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\PendingEquipmentList;
use App\Models\Notification;
use App\Models\EquipmentList;
use App\Models\Point;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class EquipmentListController extends Controller
{

    public function index(Request $request)
    {
        $query = EquipmentList::with(['point.department.branch']);
        

        $query = PermissionHelper::filterEquipmentList($query);
        
  
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('point_id')) {
            $query->where('point_id', $request->point_id);
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        

        $lists = $query->paginate(15)->appends($request->query());
        
    
        $pointsQuery = Point::with(['department.branch']);
        $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        $points = $pointsQuery->orderBy('name')->get();
        
        return view('equipment-lists.index', compact('lists', 'points'));
    }

    public function create()
    {
        $query = Point::with(['department.branch']);
        
  
        if (PermissionHelper::isGuest()) {
            $query->where('department_id', PermissionHelper::getDeptId());
        } else {
           
            $query = PermissionHelper::filterPoint($query);
        }
        
        $points = $query->orderBy('name')->get();
        
        return view('equipment-lists.create', compact('points'));
    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:200',
   
        'point_id' => 'required|exists:points,id',
        'description' => 'nullable|string',
        'status' => 'required|in:0,1'
    ]);

   
    if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
      
        $pending = PendingEquipmentList::create([
            'name' => $request->name,
            'point_id' => $request->point_id,
            'description' => $request->description,
            'status' => $request->status,
            'action_type' => 'create',
            'approval_status' => 'pending',
            'requested_by' => session('user_id'),
            'requested_at' => now(),
        ]);
        

        $this->sendApprovalNotification($pending->id, 'equipment_lists', 'create');
        
        return redirect()->route('equipment-lists.index')
            ->with('success', 'Yêu cầu thêm danh sách thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
    }
    
   
    EquipmentList::create([
        'name' => $request->name,

        'point_id' => $request->point_id,
        'description' => $request->description,
        'status' => $request->status
    ]);

    return redirect()->route('equipment-lists.index')
        ->with('success', 'Thêm danh sách thiết bị thành công!');
}

  
public function edit($id)
{
    $list = EquipmentList::findOrFail($id);
    
    // Kiểm tra quyền sửa
    if (!PermissionHelper::canViewAll() && !PermissionHelper::isUser()) {
        $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
        if (!in_array($list->point_id, $allowedPoints)) {
            abort(403, 'Bạn không có quyền sửa dữ liệu này');
        }
    }
    
    $query = Point::with(['department.branch']);
    

    if (PermissionHelper::isGuest()) {
        $query->where('department_id', PermissionHelper::getDeptId());
    } else {
        $query = PermissionHelper::filterPoint($query);
    }
    
    $points = $query->orderBy('name')->get();
    
    return view('equipment-lists.edit', compact('list', 'points'));
}

    public function update(Request $request, $id)
    {
        $list = EquipmentList::findOrFail($id);
        
        // Kiểm tra quyền sửa
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($list->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
        $request->validate([
            'name' => 'required|string|max:200',
      
            'point_id' => 'required|exists:points,id',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);
        
     
        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentList::create([
                'original_id' => $id,
                'name' => $request->name,
                // 'code' => $request->code,
                'point_id' => $request->point_id,
                'description' => $request->description,
                'status' => $request->status,
                'action_type' => 'update',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_lists', 'update');
            
            return redirect()->route('equipment-lists.index')
                ->with('success', 'Yêu cầu cập nhật danh sách thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
        
        $list->update([
            'name' => $request->name,
            'point_id' => $request->point_id,
            'description' => $request->description,
            'status' => $request->status
        ]);
        
        return redirect()->route('equipment-lists.index')
            ->with('success', 'Cập nhật danh sách thiết bị thành công!');
    }

 
    public function destroy($id)
    {
        $list = EquipmentList::findOrFail($id);
        
     
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($list->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền xóa dữ liệu này');
            }
        }
        
   
        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentList::create([
                'original_id' => $id,
                'name' => $list->name,
                'point_id' => $list->point_id,
                'description' => $list->description,
                'status' => $list->status,
                'action_type' => 'delete',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_lists', 'delete');
            
            return redirect()->route('equipment-lists.index')
                ->with('success', 'Yêu cầu xóa danh sách thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
        
        $list->delete();
        
        return redirect()->route('equipment-lists.index')
            ->with('success', 'Xóa danh sách thiết bị thành công!');
    }
    
    public function show($id)
    {
        $list = EquipmentList::with(['point.department.branch', 'categories'])->findOrFail($id);
        
        // Kiểm tra quyền xem
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($list->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền xem dữ liệu này');
            }
        }
        
        return view('equipment-lists.show', compact('list'));
    }

    private function sendApprovalNotification($pendingId, $table, $action)
{

    $admins = Admin::whereIn('role_id', [0, 1])->get();
    
    $actionText = [
        'create' => 'thêm mới',
        'update' => 'cập nhật',
        'delete' => 'xóa'
    ];
    
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Yêu cầu duyệt mới',
            'message' => 'Có yêu cầu ' . $actionText[$action] . ' dữ liệu ' . $table . '. Vui lòng kiểm tra.',
            'type' => 'approval_request',
            'related_id' => $pendingId,
            'related_table' => $table,
            'is_read' => false,
            'created_at' => now(),
        ]);
    }
}
}