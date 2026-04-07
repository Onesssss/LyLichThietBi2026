<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Helpers\PermissionHelper;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Notification::where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Đánh dấu đã đọc
        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('notifications.index', compact('notifications'));
    }
    
 
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', session('user_id'))
            ->first();
        
        if ($notification) {
            $notification->delete();
        }
        
        return redirect()->route('notifications.index')
            ->with('success', 'Đã xóa thông báo');
    }
    
  
    public static function getUnreadCount()
    {
        return Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->count();
    }
}