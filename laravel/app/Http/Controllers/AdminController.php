<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display admin settings page (supplier management)
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        $users = User::latest()->get();
        $totalItems = Item::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::count();

        return view('admin.settings', compact('suppliers', 'users', 'totalItems', 'totalSuppliers', 'totalUsers'));
    }

    /**
     * Display user management page
     */
    public function users()
    {
        $users = User::latest()->get();
        $totalItems = Item::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::count();

        return view('admin.users', compact('users', 'totalItems', 'totalSuppliers', 'totalUsers'));
    }

    /**
     * Store a new supplier
     */
    public function storeSupplier(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.settings')->with('success', 'Supplier created successfully!');
    }

    /**
     * Update supplier
     */
    public function updateSupplier(Request $request, Supplier $supplier): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.settings')->with('success', 'Supplier updated successfully!');
    }

    /**
     * Delete supplier
     */
    public function destroySupplier(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('admin.settings')->with('success', 'Supplier deleted successfully!');
    }

    /**
     * Update user email
     */
    public function updateUserEmail(Request $request, User $user): RedirectResponse
    {
        // 1. Validate Inputs
        $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'admin_password' => 'required', // This can be Admin's OR User's password
        ]);

        // 2. SECURITY CHECK: Check if input matches Admin Password OR Target User Password
        $matchesAdmin = Hash::check($request->admin_password, Auth::user()->password);
        $matchesUser  = Hash::check($request->admin_password, $user->password);

        if (!$matchesAdmin && !$matchesUser) {
            // Return back with error if NEITHER match
            return back()
                ->withErrors(['admin_password' => 'Incorrect password provided.'])
                ->with('error', 'Security Check Failed: Incorrect Password.');
        }

        // 3. Perform Update
        $user->update(['email' => $request->email]);

        return redirect()->back()->with('success', 'User email updated successfully!');
    }

    /**
     * Update user password
     */
    public function updateUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8'], // The NEW password
            'admin_password' => 'required', // The authorization password
        ]);

        // 1. SECURITY CHECK: Check if input matches Admin Password OR Target User Password
        // logic: IF (Input != AdminPass) AND (Input != UserPass) THEN Fail
        
        $matchesAdmin = Hash::check($request->admin_password, Auth::user()->password);
        $matchesUser  = Hash::check($request->admin_password, $user->password);

        if (!$matchesAdmin && !$matchesUser) {
            return back()
                ->withErrors(['admin_password' => 'Incorrect password provided.'])
                ->with('error', 'Security Check Failed: Incorrect Password.');
        }

        // 2. Update the target user's password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'User password has been reset successfully!');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user): RedirectResponse
    {
        // Prevent deleting the current admin user
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}