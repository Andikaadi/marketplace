<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-store"></i> Marketplace
                </a>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8" flex-grow">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Profile Saya</h1>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- User Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Akun</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-600">Nama:</label>
                    <p class="font-semibold">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-gray-600">Email:</label>
                    <p class="font-semibold">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-gray-600">Nomor HP (WhatsApp):</label>
                    <p class="font-semibold">{{ $user->phone }}</p>
                </div>
                <div>
                    <label class="text-gray-600">Role:</label>
                    <p class="font-semibold">{{ $user->role === 'admin' ? 'Admin' : 'User' }}</p>
                </div>
                <div>
                    <label class="text-gray-600">Terdaftar sejak:</label>
                    <p class="font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- My Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Produk Saya</h2>
            
            @if($products->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($products as $product)
                        <div class="border rounded-lg overflow-hidden {{ $product->status === 'sold' ? 'opacity-75' : '' }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2 py-1 text-xs rounded {{ $product->condition == 'baru' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                        {{ $product->condition == 'baru' ? 'Baru' : 'Bekas' }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded {{ $product->status === 'active' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                        {{ $product->status === 'active' ? 'Tersedia' : 'Terjual' }}
                                    </span>
                                </div>
                                <h3 class="font-semibold mb-1">{{ $product->title }}</h3>
                                <p class="text-blue-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="flex items-center justify-between mt-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-sm {{ $product->status === 'active' ? 'text-red-600' : 'text-green-600' }} hover:underline">
                                            <i class="fas fa-toggle-on"></i> {{ $product->status === 'active' ? 'Tandai Terjual' : 'Tandai Tersedia' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-2"></i>
                    <p>Anda belum memiliki produk</p>
                    <a href="{{ route('products.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                        <i class="fas fa-plus"></i> Jual Produk Baru
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Marketplace. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
