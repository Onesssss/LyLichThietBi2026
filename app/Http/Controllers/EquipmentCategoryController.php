<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use App\Models\EquipmentList;
use App\Models\Point;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    public function index()
    {
        $categories = EquipmentCategory::with('equipmentList')->orderBy('id', 'desc')->get();
        return view('equipment-categories.index', compact('categories'));
    }

    public function create()
    {
        $lists = EquipmentList::where('status', 1)->orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get();
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
            'name.required' => 'Tên loại thiết bị không được để trống',
            'list_id.required' => 'Vui lòng chọn danh sách thiết bị'
        ]);

        EquipmentCategory::create($request->all());

        return redirect()->route('equipment-categories.index')
            ->with('success', 'Thêm loại thiết bị thành công!');
    }

    public function edit($id)
    {
        $category = EquipmentCategory::findOrFail($id);
        $lists = EquipmentList::where('status', 1)->orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get(); 
        return view('equipment-categories.edit', compact('category', 'lists', 'points'));
    }

    public function update(Request $request, $id)
    {
        $category = EquipmentCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'list_id' => 'required|exists:equipment_lists,id',
            'point_id' => 'required|exists:points,id', 
            'status' => 'required|in:0,1'
        ]);

        $category->update($request->all());

        return redirect()->route('equipment-categories.index')
            ->with('success', 'Cập nhật loại thiết bị thành công!');
    }

    public function destroy($id)
    {
        $category = EquipmentCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('equipment-categories.index')
            ->with('success', 'Xóa loại thiết bị thành công!');
    }
}