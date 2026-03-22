<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        $branches = Branch::orderBy('id', 'desc')->get();
        return view('branches.index', compact('branches'));
    }

    // Hiển thị form thêm
    public function create()
    {
        return view('branches.create');
    }

    // Lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:branches,name'
        ], [
            'name.required' => 'Tên xí nghiệp không được để trống',
            'name.unique' => 'Tên xí nghiệp đã tồn tại'
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')
            ->with('success', 'Thêm xí nghiệp thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit', compact('branch'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:branches,name,' . $id
        ], [
            'name.required' => 'Tên xí nghiệp không được để trống',
            'name.unique' => 'Tên xí nghiệp đã tồn tại'
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')
            ->with('success', 'Cập nhật xí nghiệp thành công!');
    }

    // Xóa
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Xóa xí nghiệp thành công!');
    }
}