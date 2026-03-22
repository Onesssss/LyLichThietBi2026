<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Hiển thị danh sách admin
    public function index()
    {
        $admins = Admin::with(['branch', 'department'])->orderBy('id', 'desc')->get();
        return view('admins.index', compact('admins'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admins.create', compact('branches', 'departments'));
    }

    // Lưu admin mới
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:admins,email',
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|in:0,1,2,3',
            'branch_id' => 'nullable|exists:branches,id',
            'dept_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:0,1'
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'dept_id' => $request->dept_id,
            'status' => $request->status
        ]);

        return redirect()->route('admins.index')
            ->with('success', 'Thêm người dùng thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $branches = Branch::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admins.edit', compact('admin', 'branches', 'departments'));
    }

    // Cập nhật admin
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username,' . $id,
            'email' => 'required|email|unique:admins,email,' . $id,
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|in:0,1,2,3',
            'branch_id' => 'nullable|exists:branches,id',
            'dept_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:0,1'
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'dept_id' => $request->dept_id,
            'status' => $request->status
        ];

        // Nếu có nhập mật khẩu mới thì cập nhật
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = $request->password;
        }

        $admin->update($data);

        return redirect()->route('admins.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    // Xóa admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}