<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

// ===== ROUTES KHUSUS (HARUS DI ATAS) =====
// Product CRUD - create harus di atas route parameter
Route::middleware(['auth'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Route untuk lihat produk (bisa diakses guest) - harus di bawah routes khusus
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }
        
        $myProducts = \App\Models\Product::where('user_id', $user->id)->latest()->paginate(10);
        return view('dashboard', compact('myProducts'));
    })->name('dashboard');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    });
});


// Profile routes
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.updatePassword')->middleware('auth');
Route::put('/products/{product}/status', [App\Http\Controllers\ProfileController::class, 'toggleProductStatus'])->name('products.toggleStatus')->middleware('auth');
require __DIR__.'/auth.php';
