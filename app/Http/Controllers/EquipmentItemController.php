<?php

namespace App\Http\Controllers;

use App\Models\EquipmentItem;
use App\Models\EquipmentCategory;
use App\Models\Point;
use Illuminate\Http\Request;

class EquipmentItemController extends Controller
{
    public function index()
    {
        $items = EquipmentItem::with(['category', 'category.equipmentList'])->orderBy('id', 'desc')->get();
        return view('equipment-items.index', compact('items'));
    }

    public function create()
    {
    $categories = EquipmentCategory::with(['equipmentList', 'point'])->where('status', 1)->orderBy('name')->get();
    $points = Point::with(['department.branch'])->orderBy('name')->get();
    return view('equipment-items.create', compact('categories', 'points'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:equipment_items,code',
            'category_id' => 'required|exists:equipment_categories,id',
            'point_id' => 'required|exists:points,id', 
            'material' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'expiry_date' => 'nullable|date',
            'condition' => 'required|in:1,2,3',
            'note' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        EquipmentItem::create($request->all());

        return redirect()->route('equipment-items.index')
            ->with('success', 'Thêm thiết bị thành công!');
    }

    public function edit($id)
    {
        $item = EquipmentItem::findOrFail($id);
        $categories = EquipmentCategory::with(['equipmentList', 'point'])->where('status', 1)->orderBy('name')->get();
        $points = Point::with(['department.branch'])->orderBy('name')->get();
        return view('equipment-items.edit', compact('item', 'categories', 'points'));
    }

    public function update(Request $request, $id)
    {
        $item = EquipmentItem::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:equipment_items,code,' . $id,
            'category_id' => 'required|exists:equipment_categories,id',
            'point_id' => 'required|exists:points,id', 
            'material' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer|min:0',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'expiry_date' => 'nullable|date',
            'condition' => 'required|in:1,2,3',
            'note' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        $item->update($request->all());

        return redirect()->route('equipment-items.index')
            ->with('success', 'Cập nhật thiết bị thành công!');
    }

    public function destroy($id)
    {
        $item = EquipmentItem::findOrFail($id);
        $item->delete();

        return redirect()->route('equipment-items.index')
            ->with('success', 'Xóa thiết bị thành công!');
    }
}