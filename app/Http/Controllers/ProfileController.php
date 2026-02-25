<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show user profile page
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->paginate(10);
        
        return view('profile.index', compact('user', 'products'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Toggle product status (sold/available)
     */
    public function toggleProductStatus(Product $product)
    {
        $user = Auth::user();
        
        // Ensure user owns the product
        if ($product->user_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki akses ke produk ini');
        }

        $newStatus = $product->status === 'active' ? 'sold' : 'active';
        $product->update(['status' => $newStatus]);

        $message = $newStatus === 'sold' ? 'Produk ditandai telah terjual' : 'Produk tersedia kembali';
        
        return redirect()->route('profile.index')->with('success', $message);
    }
}
