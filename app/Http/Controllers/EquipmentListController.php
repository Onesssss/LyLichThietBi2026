<?php

namespace App\Http\Controllers;

use App\Models\EquipmentList;
use App\Models\Point;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class EquipmentListController extends Controller
{
    /**
     * Hiển thị danh sách danh sách thiết bị
     */
    public function index()
    {
        $query = EquipmentList::with(['point.department.branch']);
        $query = PermissionHelper::filterEquipmentList($query);
        $lists = $query->orderBy('id', 'desc')->get();
        
        return view('equipment-lists.index', compact('lists'));
    }

    /**
     * Hiển thị form thêm mới danh sách thiết bị
     */
    public function create()
    {
        $query = Point::with(['department.branch']);
        $query = PermissionHelper::filterPoint($query);
        $points = $query->orderBy('name')->get();
        
        return view('equipment-lists.create', compact('points'));
    }

    /**
     * Lưu danh sách thiết bị mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:equipment_lists,code',
            'point_id' => 'required|exists:points,id',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1'
        ], [
            'name.required' => 'Tên danh sách không được để trống',
            'code.required' => 'Mã danh sách không được để trống',
            'code.unique' => 'Mã danh sách đã tồn tại',
            'point_id.required' => 'Vui lòng chọn chốt'
        ]);

        // Kiểm tra quyền thêm vào point này
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($request->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền thêm dữ liệu vào chốt này');
            }
        }

        EquipmentList::create([
            'name' => $request->name,
            'code' => $request->code,
            'point_id' => $request->point_id,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('equipment-lists.index')
            ->with('success', 'Thêm danh sách thiết bị thành công!');
    }

    /**
     * Hiển thị form sửa danh sách thiết bị
     */
    public function edit($id)
    {
        $list = EquipmentList::findOrFail($id);
        
        // Kiểm tra quyền sửa
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($list->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
        $query = Point::with(['department.branch']);
        $query = PermissionHelper::filterPoint($query);
        $points = $query->orderBy('name')->get();
        
        return view('equipment-lists.edit', compact('list', 'points'));
    }

    /**
     * Cập nhật danh sách thiết bị
     */
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
            'code' => 'required|string|max:50|unique:equipment_lists,code,' . $id,
            'point_id' => 'required|exists:points,id',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1'
        ], [
            'name.required' => 'Tên danh sách không được để trống',
            'code.required' => 'Mã danh sách không được để trống',
            'code.unique' => 'Mã danh sách đã tồn tại',
            'point_id.required' => 'Vui lòng chọn chốt'
        ]);
        
        // Kiểm tra quyền chuyển sang point khác
        if ($list->point_id != $request->point_id && !PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($request->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền chuyển dữ liệu sang chốt này');
            }
        }
        
        $list->update([
            'name' => $request->name,
            'code' => $request->code,
            'point_id' => $request->point_id,
            'description' => $request->description,
            'status' => $request->status
        ]);
        
        return redirect()->route('equipment-lists.index')
            ->with('success', 'Cập nhật danh sách thiết bị thành công!');
    }

    /**
     * Xóa danh sách thiết bị
     */
    public function destroy($id)
    {
        $list = EquipmentList::findOrFail($id);
        
        // Kiểm tra quyền xóa
        if (!PermissionHelper::canViewAll()) {
            $allowedPoints = PermissionHelper::filterPoint(Point::query())->pluck('id')->toArray();
            if (!in_array($list->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền xóa dữ liệu này');
            }
        }
        
        $list->delete();
        
        return redirect()->route('equipment-lists.index')
            ->with('success', 'Xóa danh sách thiết bị thành công!');
    }
    
    /**
     * Hiển thị chi tiết danh sách thiết bị (tùy chọn)
     */
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
}