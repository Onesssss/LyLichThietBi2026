<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Branch;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        $departments = Department::with('branch')->orderBy('id', 'desc')->get();
        return view('departments.index', compact('departments'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        return view('departments.create', compact('branches'));
    }

    // Lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:100|unique:departments,name'
        ]);

        Department::create($request->only('branch_id', 'name'));

        return redirect()->route('departments.index')
            ->with('success', 'Thêm phòng ban thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $branches = Branch::orderBy('name')->get();
        return view('departments.edit', compact('department', 'branches'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:100|unique:departments,name,' . $id
        ]);

        $department->update($request->only('branch_id', 'name'));

        return redirect()->route('departments.index')
            ->with('success', 'Cập nhật phòng ban thành công!');
    }

    // Xóa
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Xóa phòng ban thành công!');
    }
}