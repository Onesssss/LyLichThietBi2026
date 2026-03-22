<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\PasswordResetRequest;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // Hiển thị form quên mật khẩu
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    // Xử lý gửi yêu cầu
    public function sendRequest(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại trong hệ thống'
        ]);

        // Lấy thông tin user
        $user = Admin::where('email', $request->email)->first();

        // Kiểm tra đã có yêu cầu chờ xử lý chưa
        $existingRequest = PasswordResetRequest::where('email', $request->email)
            ->where('status', 0)
            ->first();

        if ($existingRequest) {
            return back()->with('warning', 'Yêu cầu đã được gửi trước đó. Vui lòng chờ Admin xử lý!');
        }

        // Tạo yêu cầu mới
        PasswordResetRequest::create([
            'email' => $request->email,
            'full_name' => $user->full_name,
            'status' => 0,
            'requested_at' => now(),
            'processed_by' => null
        ]);

        return back()->with('success', 'Yêu cầu đã được gửi! Admin sẽ liên hệ để cấp lại mật khẩu.');
    }

     // Hiển thị danh sách yêu cầu cho Admin
    public function index()
    {
        // Kiểm tra quyền (chỉ Admin role_id 0,1)
        if (!in_array(session('role_id'), [0, 1])) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $requests = PasswordResetRequest::with('processor')
            ->orderBy('id', 'desc')
            ->get();

        return view('admins.password-requests', compact('requests'));
    }

    // Hiển thị form reset mật khẩu
    public function resetForm($id)
    {
        if (!in_array(session('role_id'), [0, 1])) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $request = PasswordResetRequest::findOrFail($id);
        
        // Chỉ xử lý yêu cầu chưa được xử lý
        if ($request->status == 1) {
            return redirect()->route('password-requests.index')
                ->with('error', 'Yêu cầu này đã được xử lý trước đó!');
        }

        return view('admins.reset-password', compact('request'));
    }

    // Xử lý reset mật khẩu
    public function resetPassword(Request $request, $id)
    {
        if (!in_array(session('role_id'), [0, 1])) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        $request->validate([
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password'
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp'
        ]);

        $resetRequest = PasswordResetRequest::findOrFail($id);
        
        // Cập nhật mật khẩu mới cho user
        $user = Admin::where('email', $resetRequest->email)->first();
        $user->update([
            'password' => $request->new_password
        ]);

        // Cập nhật trạng thái yêu cầu
        $resetRequest->update([
            'status' => 1,
            'processed_at' => now(),
            'processed_by' => session('user_id')
        ]);

        return redirect()->route('password-requests.index')
            ->with('success', 'Đã cấp lại mật khẩu cho ' . $user->full_name);
    }
}