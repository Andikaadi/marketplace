<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Jual Beli Barang Bekas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-store"></i> Marketplace
                </a>
                
                <!-- Search -->
                <form action="{{ route('home') }}" method="GET" class="flex-1 max-w-xl w-full">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." 
                            class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Filter Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
            <form action="{{ route('home') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <!-- Category Filter -->
                <select name="category" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Condition Filter -->
                <select name="condition" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kondisi</option>
                    <option value="baru" {{ request('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="bekas" {{ request('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                </select>
                
                <!-- Price Range -->
                <div class="flex items-center space-x-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                        class="w-24 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-400">-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                        class="w-24 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Location -->
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Lokasi..." 
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter"></i> Filter
                </button>
                
                @if(request()->anyFilled(['search', 'category', 'condition', 'min_price', 'max_price', 'location']))
                    <a href="{{ route('home') }}" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-grow" flex-grow">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-box-open"></i> Produk Terbaru
            </h1>
            <span class="text-gray-600">{{ $products->total() }} produk ditemukan</span>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Tidak ada produk ditemukan</p>
                <p class="text-gray-400">Coba ubah filter atau kata kunci pencarian</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <span class="absolute top-2 left-2 px-2 py-1 text-xs rounded {{ $product->condition == 'baru' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                {{ $product->condition == 'baru' ? 'Baru' : 'Bekas' }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $product->title }}</h3>
                            <p class="text-lg font-bold text-blue-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="flex items-center justify-between mt-3 text-sm text-gray-500">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $product->location }}</span>
                                <span>{{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Marketplace. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
