<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-store"></i> Marketplace Admin
                </a>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        <i class="fas fa-user-shield"></i> {{ Auth::user()->name }} (Admin)
                    </span>
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-home"></i> Lihat Website
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Content -->
    <main class="container mx-auto px-4 py-8 flex-grow" flex-grow">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Users</p>
                        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Products</p>
                        <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <a href="{{ route('admin.users') }}" class="flex items-center hover:text-blue-600">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Kelola Users</p>
                        <p class="text-lg font-semibold">Lihat Semua <i class="fas fa-arrow-right"></i></p>
                    </div>
                </a>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <a href="{{ route('admin.products') }}" class="flex items-center hover:text-blue-600">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Kelola Products</p>
                        <p class="text-lg font-semibold">Lihat Semua <i class="fas fa-arrow-right"></i></p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-users"></i> Recent Users
                </h2>
                <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">No. HP</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users->take(5) as $user)
                        <tr class="border-t">
                            <td class="py-3">{{ $user->name }}</td>
                            <td class="py-3">{{ $user->email }}</td>
                            <td class="py-3">{{ $user->phone ?? '-' }}</td>
                            <td class="py-3">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 text-xs rounded bg-red-500 text-white">Admin</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-blue-500 text-white">User</span>
                                @endif
                            </td>
                            <td class="py-3">{{ $user->products->count() }}</td>
                            <td class="py-3">{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-box-open"></i> Recent Products
                </h2>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Penjual</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products->take(5) as $product)
                        <tr class="border-t">
                            <td class="py-3">{{ $product->title }}</td>
                            <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3">{{ $product->user->name }}</td>
                            <td class="py-3">{{ $product->category->name ?? '-' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded {{ $product->status == 'active' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                    {{ $product->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
