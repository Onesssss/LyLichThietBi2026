<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $error = '';
        $email = $request->email;
        $password_input = $request->password;

        // Validate
        if (empty($email) || empty($password_input)) {
            $error = 'Vui lòng nhập email và mật khẩu';
            return view('auth.login', compact('error', 'email'));
        }

        try {
            // Tìm user theo email
            $user = Admin::where('email', $email)->first();

            if ($user) {
                // So sánh mật khẩu (plain text)
                if (trim($password_input) === trim($user->password)) {

                    // Kiểm tra trạng thái
                    if ($user->status == 0) {
                        $error = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.';
                        return view('auth.login', compact('error', 'email'));
                    }

                    // ✅ Tạo session
                    session()->regenerate();

                    session([
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'fullname' => $user->full_name ?? $user->username,
                        'email' => $user->email,
                        'role_id' => $user->role_id,
                        'branch_id' => $user->branch_id,
                        'dept_id' => $user->dept_id,
                        'logged_in' => true,
                        'user_ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'created' => time(),
                        'last_activity' => time(),
                    ]);

                    // 🔥 LOG
                    Log::info('LOGIN SUCCESS', [
                        'user_id' => $user->id,
                        'role_id' => $user->role_id,
                        'username' => $user->username
                    ]);

                    session()->save();

                    return redirect()->route('home');

                } else {
                    $error = 'Mật khẩu không chính xác';
                }
            } else {
                $error = 'Email không tồn tại trong hệ thống';
            }

        } catch (\Exception $e) {
            $error = "Lỗi hệ thống: " . $e->getMessage();
        }

        return view('auth.login', compact('error', 'email'));
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}