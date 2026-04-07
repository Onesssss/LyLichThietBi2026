<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
        {
            // Kiểm tra quyền
            if (!PermissionHelper::canManageBranches()) {
                abort(403, 'Bạn không có quyền truy cập');
            }
            
            $query = Branch::query();
            $query = PermissionHelper::filterBranch($query);
            $branches = $query->orderBy('id', 'desc')->get();
            
            return view('branches.index', compact('branches'));
        }


    public function create()
    {
        if (!PermissionHelper::canManageBranches()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
        return view('branches.create');
    }

    public function store(Request $request)
    {
        if (!PermissionHelper::canManageBranches()) {
            abort(403, 'Bạn không có quyền thêm mới');
        }
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

    public function edit($id)
    {
        if (!PermissionHelper::canManageBranches()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $branch = Branch::findOrFail($id);

        if (PermissionHelper::isUser() && $branch->id != PermissionHelper::getBranchId()) {
            abort(403, 'Bạn không có quyền sửa xí nghiệp này');
        }
        
        return view('branches.edit', compact('branch'));
    }


    public function update(Request $request, $id)
    {
        if (!PermissionHelper::canManageBranches()) {
            abort(403, 'Bạn không có quyền sửa');
        }
        
        $branch = Branch::findOrFail($id);
        
        if (PermissionHelper::isUser() && $branch->id != PermissionHelper::getBranchId()) {
            abort(403, 'Bạn không có quyền sửa xí nghiệp này');
        }

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


    public function destroy($id)
    {
        if (!PermissionHelper::isAdmin()) {
            abort(403, 'Chỉ Admin mới có quyền xóa');
        }
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Xóa xí nghiệp thành công!');
    }
}