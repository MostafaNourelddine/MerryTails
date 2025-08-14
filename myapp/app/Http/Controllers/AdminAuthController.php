<?php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        // If already authenticated, redirect to admin dashboard
        if (session()->has('admin_authenticated')) {
            return redirect()->route('admin.index');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find admin user by username
        $adminUser = AdminUser::where('username', $request->username)->first();

        // Check if user exists, is active, and password matches
        if ($adminUser && $adminUser->isActive() && Hash::check($request->password, $adminUser->password)) {
            // Update last login timestamp
            $adminUser->updateLastLogin();
            
            // Store admin user ID in session
            session(['admin_authenticated' => true, 'admin_user_id' => $adminUser->id]);
            
            return redirect()->route('admin.index')->with('success', 'Welcome back, ' . ($adminUser->name ?: $adminUser->username) . '!');
        }

        return back()->withErrors([
            'credentials' => 'Invalid username or password.',
        ])->withInput($request->only('username'));
    }

    public function logout()
    {
        session()->forget(['admin_authenticated', 'admin_user_id']);
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $adminUser = AdminUser::find(session('admin_user_id'));
        
        if (!$adminUser || !Hash::check($request->current_password, $adminUser->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $adminUser->update(['password' => $request->new_password]);
        
        return back()->with('success', 'Password changed successfully!');
    }
}
