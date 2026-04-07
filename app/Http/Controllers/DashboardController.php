<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Point;
use App\Models\EquipmentItem;
use App\Models\EquipmentCategory;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;  

class DashboardController extends Controller
{
    public function index()
    {

        $totalBranches = Branch::count();
        $totalDepartments = Department::count();
        $totalPoints = Point::count();
        $totalEquipment = EquipmentItem::count();
        

        $activeEquipment = EquipmentItem::where('status', 1)->count();
        $inactiveEquipment = EquipmentItem::where('status', 0)->count();
        

        $goodCount = EquipmentItem::where('condition', 1)->count();
        $mediumCount = EquipmentItem::where('condition', 2)->count();
        $brokenCount = EquipmentItem::where('condition', 3)->count();
        

        $total = $goodCount + $mediumCount + $brokenCount;
        $goodPercent = $total > 0 ? round(($goodCount / $total) * 100, 1) : 0;
        $mediumPercent = $total > 0 ? round(($mediumCount / $total) * 100, 1) : 0;
        $brokenPercent = $total > 0 ? round(($brokenCount / $total) * 100, 1) : 0;
        
   
        $expiringSoon = EquipmentItem::where('expiry_date', '>=', now())
            ->where('expiry_date', '<=', now()->addDays(30))
            ->count();
        
   
        $monthlyData = EquipmentItem::select(
                DB::raw('MONTH(updated_at) as month'),
                DB::raw('YEAR(updated_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('condition', 3)
            ->where('updated_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => 'T' . $item->month . '/' . $item->year,
                    'count' => $item->count
                ];
            });
        
        if ($monthlyData->isEmpty()) {
            $monthlyData = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthlyData->push([
                    'month' => 'T' . $month->month . '/' . $month->year,
                    'count' => 0
                ]);
            }
        }
        
        $pieData = [
            ['name' => 'Tốt', 'value' => $goodCount, 'color' => '#28a745'],
            ['name' => 'Trung bình', 'value' => $mediumCount, 'color' => '#ffc107'],
            ['name' => 'Hỏng', 'value' => $brokenCount, 'color' => '#dc3545'],
        ];
        


    $topExpiringEquipment = EquipmentItem::select(
            'equipment_items.id',
            'equipment_items.name',
            'equipment_items.expiry_date',
            'points.name as point_name'
        )
        ->leftJoin('points', 'equipment_items.point_id', '=', 'points.id')
        ->where('equipment_items.expiry_date', '>=', Carbon::now())
        ->where('equipment_items.expiry_date', '<=', Carbon::now()->addDays(30))
        ->orderBy('equipment_items.expiry_date', 'asc')
        ->limit(5)
        ->get();

   

$topBrokenEquipment = EquipmentItem::select(
        'equipment_items.id',
        'equipment_items.name',
        'points.name as point_name',
        DB::raw('COUNT(equipment_items.id) as broken_count')
    )
    ->leftJoin('points', 'equipment_items.point_id', '=', 'points.id')
    ->where('equipment_items.condition', 3)
    ->groupBy('equipment_items.id', 'equipment_items.name', 'points.name')
    ->orderBy('broken_count', 'desc')
    ->limit(5)
    ->get();
        
        return view('dashboard.index', compact(
            'totalBranches',
            'totalDepartments',
            'totalPoints',
            'totalEquipment',
            'goodCount',
            'mediumCount',
            'brokenCount',
            'expiringSoon',
            'monthlyData',
            'pieData',
            'topBrokenEquipment',
            'topExpiringEquipment'  
        ));
    }
    

    public function getBrokenEquipment()
    {
        $brokenEquipment = EquipmentItem::with(['category', 'point'])
            ->where('condition', 3)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json($brokenEquipment);
    }
}