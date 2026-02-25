<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Check if user is admin
     */
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Display admin dashboard
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $users = User::with('products')->paginate(20);
        $products = Product::with(['user', 'category'])->paginate(20);
        $totalUsers = User::count();
        $totalProducts = Product::count();

        return view('admin.index', compact('users', 'products', 'totalUsers', 'totalProducts'));
    }

    /**
     * Display all users
     */
    public function users()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $users = User::with('products')->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Display all products
     */
    public function products()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $products = Product::with(['user', 'category'])->paginate(20);
        return view('admin.products', compact('products'));
    }

    /**
     * Delete user
     */
    public function destroyUser(string $id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $user = User::findOrFail($id);
        
        // Delete user's products
        foreach ($user->products as $product) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        }
        
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Delete product
     */
    public function destroyProduct(string $id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $product = Product::findOrFail($id);
        
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }
}
