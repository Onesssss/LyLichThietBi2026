<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use App\Models\PendingEquipmentItem;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\EquipmentItem;
use App\Models\EquipmentCategory;
use App\Models\Point;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class EquipmentItemController extends Controller
{
    public function index(Request $request)
    {
        $query = EquipmentItem::with(['category.equipmentList', 'point.department.branch']);
        
        // Áp dụng quyền
        $query = PermissionHelper::filterEquipmentList($query, 'category.list_id');
        
        
        $categoriesQuery = EquipmentCategory::with(['equipmentList', 'point.department.branch']);
        $categoriesQuery = PermissionHelper::filterEquipmentList($categoriesQuery, 'list_id');
        // $categories = $categoriesQuery->orderBy('name')->get()
        //     ->map(function($cat) {
        //         $cat->display_name = '[' . ($cat->equipmentList->name ?? '') . '] ' . $cat->name;
        //         return $cat;
        //     });
        $categories = EquipmentCategory::orderBy('name')
    ->get()
    ->unique('name')
    ->values();
        
    
        $pointsQuery = Point::with(['department.branch']);
        $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        $points = $pointsQuery->orderBy('name')->get();
        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        

        if ($request->filled('point_id')) {
            $query->where('point_id', $request->point_id);
        }
        
        if ($request->filled('manufacture_year_from')) {
            $query->where('manufacture_year', '>=', $request->manufacture_year_from);
        }
        if ($request->filled('manufacture_year_to')) {
            $query->where('manufacture_year', '<=', $request->manufacture_year_to);
        }
        
        if ($request->filled('expiry_date_from')) {
            $query->where('expiry_date', '>=', $request->expiry_date_from);
        }
        if ($request->filled('expiry_date_to')) {
            $query->where('expiry_date', '<=', $request->expiry_date_to);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        
  
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
   
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        

        $items = $query->paginate(15)->appends($request->query());
        
        return view('equipment-items.index', compact('items', 'categories', 'points'));

        
    }


    public function create()
    {
        
        $categoriesQuery = EquipmentCategory::with(['equipmentList', 'point.department.branch']);
        
   
        if (PermissionHelper::isGuest()) {
            $categoriesQuery->whereHas('point', function($q) {
                $q->where('department_id', PermissionHelper::getDeptId());
            });
        } else {
            $categoriesQuery = PermissionHelper::filterEquipmentList($categoriesQuery, 'list_id');
        }
        $categories = $categoriesQuery->where('status', 1)->orderBy('name')->get();
        
        $pointsQuery = Point::with(['department.branch']);
        
        if (PermissionHelper::isGuest()) {
            $pointsQuery->where('department_id', PermissionHelper::getDeptId());
        } else {
            $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        }
        $points = $pointsQuery->orderBy('name')->get();
        
        return view('equipment-items.create', compact('categories', 'points'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
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


        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentItem::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'point_id' => $request->point_id,
                'material' => $request->material,
                'unit' => $request->unit,
                'quantity' => $request->quantity,
                'manufacture_year' => $request->manufacture_year,
                'expiry_date' => $request->expiry_date,
                'condition' => $request->condition,
                'note' => $request->note,
                'status' => $request->status,
                'action_type' => 'create',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_items', 'create');
            
            return redirect()->route('equipment-items.index')
                ->with('success', 'Yêu cầu thêm thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
        EquipmentItem::create($request->all());

        return redirect()->route('equipment-items.index')
            ->with('success', 'Thêm thiết bị thành công!');
    }

    public function edit($id)
    {
        $item = EquipmentItem::findOrFail($id);
        
        if (PermissionHelper::isGuest()) {
            $allowedPoints = Point::where('department_id', PermissionHelper::getDeptId())->pluck('id')->toArray();
            if (!in_array($item->point_id, $allowedPoints)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        } elseif (!PermissionHelper::canViewAll() && !PermissionHelper::isUser()) {
            $allowedCategories = PermissionHelper::filterEquipmentList(EquipmentCategory::query(), 'list_id')->pluck('id')->toArray();
            if (!in_array($item->category_id, $allowedCategories)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
    
        $categoriesQuery = EquipmentCategory::with(['equipmentList', 'point.department.branch']);
        
        if (PermissionHelper::isGuest()) {
            $categoriesQuery->whereHas('point', function($q) {
                $q->where('department_id', PermissionHelper::getDeptId());
            });
        } else {
            $categoriesQuery = PermissionHelper::filterEquipmentList($categoriesQuery, 'list_id');
        }
        $categories = $categoriesQuery->where('status', 1)->orderBy('name')->get();
        

        $pointsQuery = Point::with(['department.branch']);
        
        if (PermissionHelper::isGuest()) {
            $pointsQuery->where('department_id', PermissionHelper::getDeptId());
        } else {
            $pointsQuery = PermissionHelper::filterPoint($pointsQuery);
        }
        $points = $pointsQuery->orderBy('name')->get();
        
        return view('equipment-items.edit', compact('item', 'categories', 'points'));
    }

    public function update(Request $request, $id)
    {
        $item = EquipmentItem::findOrFail($id);
        
        // Kiểm tra quyền sửa
        if (!PermissionHelper::canViewAll()) {
            $allowedCategories = PermissionHelper::filterEquipmentList(EquipmentCategory::query(), 'list_id')->pluck('id')->toArray();
            if (!in_array($item->category_id, $allowedCategories)) {
                abort(403, 'Bạn không có quyền sửa dữ liệu này');
            }
        }
        
        $request->validate([
            'name' => 'required|string|max:200',
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
        

        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentItem::create([
                'original_id' => $id,
                'name' => $request->name,
                'category_id' => $request->category_id,
                'point_id' => $request->point_id,
                'material' => $request->material,
                'unit' => $request->unit,
                'quantity' => $request->quantity,
                'manufacture_year' => $request->manufacture_year,
                'expiry_date' => $request->expiry_date,
                'condition' => $request->condition,
                'note' => $request->note,
                'status' => $request->status,
                'action_type' => 'update',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_items', 'update');
            
            return redirect()->route('equipment-items.index')
                ->with('success', 'Yêu cầu cập nhật thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        

        $item->update($request->all());
        
        return redirect()->route('equipment-items.index')
            ->with('success', 'Cập nhật thiết bị thành công!');
    }

    public function destroy($id)
    {
        $item = EquipmentItem::findOrFail($id);

        if (!PermissionHelper::canViewAll()) {
            $allowedCategories = PermissionHelper::filterEquipmentList(EquipmentCategory::query(), 'list_id')->pluck('id')->toArray();
            if (!in_array($item->category_id, $allowedCategories)) {
                abort(403, 'Bạn không có quyền xóa dữ liệu này');
            }
        }
        

        if (PermissionHelper::isUser() || PermissionHelper::isGuest()) {
            $pending = PendingEquipmentItem::create([
                'original_id' => $id,
                'name' => $item->name,
                // 'code' => $item->code,
                'category_id' => $item->category_id,
                'point_id' => $item->point_id,
                'material' => $item->material,
                'unit' => $item->unit,
                'quantity' => $item->quantity,
                'manufacture_year' => $item->manufacture_year,
                'expiry_date' => $item->expiry_date,
                'condition' => $item->condition,
                'note' => $item->note,
                'status' => $item->status,
                'action_type' => 'delete',
                'approval_status' => 'pending',
                'requested_by' => session('user_id'),
                'requested_at' => now(),
            ]);
            
            $this->sendApprovalNotification($pending->id, 'equipment_items', 'delete');
            
            return redirect()->route('equipment-items.index')
                ->with('success', 'Yêu cầu xóa thiết bị đã được gửi! Vui lòng chờ Admin duyệt.');
        }
        
    
        $item->delete();
        
        return redirect()->route('equipment-items.index')
            ->with('success', 'Xóa thiết bị thành công!');
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
            'equipment_items' => 'thiết bị'
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


public function exportExcel(Request $request)
{
    $query = EquipmentItem::with([
        'category.point.department.branch'
    ]);
    
    
    // Áp dụng bộ lọc (giống index)
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    
    if ($request->filled('point_id')) {
        $query->where('point_id', $request->point_id);
    }
    
    if ($request->filled('manufacture_year_from')) {
        $query->where('manufacture_year', '>=', $request->manufacture_year_from);
    }
    
    if ($request->filled('manufacture_year_to')) {
        $query->where('manufacture_year', '<=', $request->manufacture_year_to);
    }
    
    if ($request->filled('expiry_date_from')) {
        $query->where('expiry_date', '>=', $request->expiry_date_from);
    }
    
    if ($request->filled('expiry_date_to')) {
        $query->where('expiry_date', '<=', $request->expiry_date_to);
    }
    
    if ($request->filled('condition')) {
        $query->where('condition', $request->condition);
    }
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    $items = $query->orderBy('id', 'desc')->get();
    

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
   
    $headers = ['STT', 'Xí nghiệp', 'Cung', 'Chốt', 'Loại thiết bị', 'Tên thiết bị', 
                'Vật liệu', 'Đơn vị', 'Số lượng', 'Năm SX', 'Hạn dùng', 'Tình trạng', 'Ghi chú'];
    
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
        $sheet->getStyle($col . '1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE0E0E0');
        $sheet->getStyle($col . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $col++;
    }
    
  
    $row = 2;
    $stt = 1;
    
foreach ($items as $item) {
   
    $point = \App\Models\Point::find($item->point_id);

    $pointName = 'N/A';
    $departmentName = 'N/A';
    $branchName = 'N/A';
   
    if ($point) {
        $pointName = $point->name;
        
  
        $department = \App\Models\Department::find($point->department_id);
        
        if ($department) {
            $departmentName = $department->name;
            
     
            $branch = \App\Models\Branch::find($department->branch_id);
            
            if ($branch) {
                $branchName = $branch->name;
            }
        }
    }
    

    $category = \App\Models\EquipmentCategory::find($item->category_id);
    $categoryName = $category ? $category->name : 'N/A';
    
   
    $conditionText = '';
    if ($item->condition == 1) {
        $conditionText = 'Tốt';
    } elseif ($item->condition == 2) {
        $conditionText = 'Trung bình';
    } elseif ($item->condition == 3) {
        $conditionText = 'Hỏng';
    }
    
    // Đổ dữ liệu vào Excel
    $sheet->setCellValue('A' . $row, $stt++);
    $sheet->setCellValue('B' . $row, $branchName);      
    $sheet->setCellValue('C' . $row, $departmentName); 
    $sheet->setCellValue('D' . $row, $pointName);      
    $sheet->setCellValue('E' . $row, $categoryName);    
    $sheet->setCellValue('F' . $row, $item->name);     
    $sheet->setCellValue('G' . $row, $item->material ?? '---');    
    $sheet->setCellValue('H' . $row, $item->unit ?? '---');        
    $sheet->setCellValue('I' . $row, $item->quantity ?? 0);       
    $sheet->setCellValue('J' . $row, $item->manufacture_year ?? '---');  
    $sheet->setCellValue('K' . $row, $item->expiry_date ?? '---');      
    $sheet->setCellValue('L' . $row, $conditionText);   
    $sheet->setCellValue('M' . $row, $item->note ?? '---');   
    
    $row++;
}
    
    // Auto resize cột
    foreach (range('A', 'M') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // Set border
    $lastRow = $row - 1;
    if ($lastRow >= 2) {
        $sheet->getStyle('A1:M' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
    }
    
    // Tạo file và download
    $writer = new Xlsx($spreadsheet);
    $filename = 'danh_sach_thiet_bi_' . date('Ymd_His') . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}
}