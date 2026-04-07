<?php

namespace App\Http\Controllers;

use App\Models\PendingEquipmentList;
use App\Models\PendingEquipmentCategory;
use App\Models\PendingEquipmentItem;
use App\Models\EquipmentList;
use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use App\Models\Notification;
use App\Models\Admin;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    public function __construct()
    {

        if (!PermissionHelper::canViewAll()) {
            abort(403, 'Bạn không có quyền truy cập');
        }
    }


    public function index()
    {
        $pendingLists = PendingEquipmentList::where('approval_status', 'pending')
            ->with('requester')
            ->orderBy('requested_at', 'desc')
            ->get();
            
        $pendingCategories = PendingEquipmentCategory::where('approval_status', 'pending')
            ->with('requester')
            ->orderBy('requested_at', 'desc')
            ->get();
            
        $pendingItems = PendingEquipmentItem::where('approval_status', 'pending')
            ->with('requester')
            ->orderBy('requested_at', 'desc')
            ->get();
            
        $totalPending = $pendingLists->count() + $pendingCategories->count() + $pendingItems->count();
        
        return view('admin.pending.index', compact('pendingLists', 'pendingCategories', 'pendingItems', 'totalPending'));
    }

  
    public function showList($id)
    {
        $pending = PendingEquipmentList::with('requester')->findOrFail($id);
        return view('admin.pending.approve-list', compact('pending'));
    }


    public function showCategory($id)
    {
        $pending = PendingEquipmentCategory::with('requester')->findOrFail($id);
        return view('admin.pending.approve-category', compact('pending'));
    }


    public function showItem($id)
    {
        $pending = PendingEquipmentItem::with('requester')->findOrFail($id);
        return view('admin.pending.approve-item', compact('pending'));
    }


    public function approveList($id)
    {
        $pending = PendingEquipmentList::findOrFail($id);
        
        if ($pending->action_type == 'create') {
            // Tạo mới
            $list = EquipmentList::create([
                'name' => $pending->name,
                'code' => $pending->code,
                'point_id' => $pending->point_id,
                'description' => $pending->description,
                'status' => $pending->status
            ]);
        } elseif ($pending->action_type == 'update') {
            // Cập nhật
            $list = EquipmentList::find($pending->original_id);
            if ($list) {
                $list->update([
                    'name' => $pending->name,
                    'code' => $pending->code,
                    'point_id' => $pending->point_id,
                    'description' => $pending->description,
                    'status' => $pending->status
                ]);
            }
        } elseif ($pending->action_type == 'delete') {
            $list = EquipmentList::find($pending->original_id);
            if ($list) {
                $list->delete();
            }
        }
        

        $pending->update([
            'approval_status' => 'approved',
            'approved_by' => session('user_id'),
            'approved_at' => now()
        ]);
        

        $this->sendNotificationToRequester($pending->requested_by, 'approved', 'equipment_lists', $pending->action_type);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã duyệt yêu cầu thành công!');
    }


    public function approveCategory($id)
    {
        $pending = PendingEquipmentCategory::findOrFail($id);
        
        if ($pending->action_type == 'create') {
            EquipmentCategory::create([
                'name' => $pending->name,
                'list_id' => $pending->list_id,
                'point_id' => $pending->point_id,
                'status' => $pending->status
            ]);
        } elseif ($pending->action_type == 'update') {
            $category = EquipmentCategory::find($pending->original_id);
            if ($category) {
                $category->update([
                    'name' => $pending->name,
                    'list_id' => $pending->list_id,
                    'point_id' => $pending->point_id,
                    'status' => $pending->status
                ]);
            }
        } elseif ($pending->action_type == 'delete') {
            $category = EquipmentCategory::find($pending->original_id);
            if ($category) {
                $category->delete();
            }
        }
        
        $pending->update([
            'approval_status' => 'approved',
            'approved_by' => session('user_id'),
            'approved_at' => now()
        ]);
        
        $this->sendNotificationToRequester($pending->requested_by, 'approved', 'equipment_categories', $pending->action_type);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã duyệt yêu cầu thành công!');
    }


    public function approveItem($id)
    {
        $pending = PendingEquipmentItem::findOrFail($id);
        
        if ($pending->action_type == 'create') {
            EquipmentItem::create([
                'name' => $pending->name,
                'code' => $pending->code,
                'category_id' => $pending->category_id,
                'point_id' => $pending->point_id,
                'material' => $pending->material,
                'unit' => $pending->unit,
                'quantity' => $pending->quantity,
                'manufacture_year' => $pending->manufacture_year,
                'expiry_date' => $pending->expiry_date,
                'condition' => $pending->condition,
                'note' => $pending->note,
                'status' => $pending->status
            ]);
        } elseif ($pending->action_type == 'update') {
            $item = EquipmentItem::find($pending->original_id);
            if ($item) {
                $item->update([
                    'name' => $pending->name,
                    'code' => $pending->code,
                    'category_id' => $pending->category_id,
                    'point_id' => $pending->point_id,
                    'material' => $pending->material,
                    'unit' => $pending->unit,
                    'quantity' => $pending->quantity,
                    'manufacture_year' => $pending->manufacture_year,
                    'expiry_date' => $pending->expiry_date,
                    'condition' => $pending->condition,
                    'note' => $pending->note,
                    'status' => $pending->status
                ]);
            }
        } elseif ($pending->action_type == 'delete') {
            $item = EquipmentItem::find($pending->original_id);
            if ($item) {
                $item->delete();
            }
        }
        
        $pending->update([
            'approval_status' => 'approved',
            'approved_by' => session('user_id'),
            'approved_at' => now()
        ]);
        
        $this->sendNotificationToRequester($pending->requested_by, 'approved', 'equipment_items', $pending->action_type);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã duyệt yêu cầu thành công!');
    }


    public function rejectList(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $pending = PendingEquipmentList::findOrFail($id);
        
        $pending->update([
            'approval_status' => 'rejected',
            'approved_by' => session('user_id'),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);
        
        $this->sendNotificationToRequester($pending->requested_by, 'rejected', 'equipment_lists', $pending->action_type, $request->rejection_reason);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã từ chối yêu cầu!');
    }


    public function rejectCategory(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $pending = PendingEquipmentCategory::findOrFail($id);
        
        $pending->update([
            'approval_status' => 'rejected',
            'approved_by' => session('user_id'),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);
        
        $this->sendNotificationToRequester($pending->requested_by, 'rejected', 'equipment_categories', $pending->action_type, $request->rejection_reason);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã từ chối yêu cầu!');
    }

  
    public function rejectItem(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $pending = PendingEquipmentItem::findOrFail($id);
        
        $pending->update([
            'approval_status' => 'rejected',
            'approved_by' => session('user_id'),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);
        
        $this->sendNotificationToRequester($pending->requested_by, 'rejected', 'equipment_items', $pending->action_type, $request->rejection_reason);
        
        return redirect()->route('admin.pending.index')
            ->with('success', 'Đã từ chối yêu cầu!');
    }


    private function sendNotificationToRequester($userId, $status, $table, $action, $reason = null)
    {
        $actionText = [
            'create' => 'thêm mới',
            'update' => 'cập nhật',
            'delete' => 'xóa'
        ];
        
        $tableText = [
            'equipment_lists' => 'danh sách thiết bị',
            'equipment_categories' => 'danh mục thiết bị',
            'equipment_items' => 'thiết bị'
        ];
        
        if ($status == 'approved') {
            $title = 'Yêu cầu đã được duyệt';
            $message = 'Yêu cầu ' . $actionText[$action] . ' ' . $tableText[$table] . ' của bạn đã được duyệt.';
        } else {
            $title = 'Yêu cầu bị từ chối';
            $message = 'Yêu cầu ' . $actionText[$action] . ' ' . $tableText[$table] . ' của bạn đã bị từ chối.';
            if ($reason) {
                $message .= ' Lý do: ' . $reason;
            }
        }
        
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $status,
            'is_read' => false,
            'created_at' => now(),
        ]);
    }
}