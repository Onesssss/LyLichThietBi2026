<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $error = '';
        $email = $request->email;
        $password_input = $request->password;

        if (empty($email) || empty($password_input)) {
            $error = 'Vui lòng nhập email và mật khẩu';
            return view('auth.login', compact('error', 'email'));
        }
        if ($email == env('ADMIN_EMAIL') && $password_input == env('ADMIN_PASSWORD')) {
            session()->regenerate();
            
            session([
                'user_id' => 999999,
                'username' => env('ADMIN_USERNAME', 'super_admin'),
                'fullname' => env('ADMIN_FULL_NAME', 'Super Admin'),
                'email' => $email,
                'role_id' => 0,
                'branch_id' => null,
                'dept_id' => null,
                'logged_in' => true,
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created' => time(),
                'last_activity' => time(),
                'is_super_admin' => true  
            ]);
            
            session()->save();
            
            Log::info('Super Admin login via .env', ['email' => $email]);
            
            return redirect()->route('home');
        }

        try {
            $user = Admin::where('email', $email)->first();

            if ($user) {
                if (trim($password_input) === trim($user->password)) {
                    if ($user->status == 0) {
                        $error = 'Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.';
                        return view('auth.login', compact('error', 'email'));
                    }

                    session()->regenerate();

                    session([
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'fullname' => $user->full_name,
                        'email' => $user->email,
                        'role_id' => $user->role_id,
                        'branch_id' => $user->branch_id,
                        'dept_id' => $user->dept_id,
                        'logged_in' => true,
                        'user_ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'created' => time(),
                        'last_activity' => time(),
                        'is_super_admin' => false
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

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}