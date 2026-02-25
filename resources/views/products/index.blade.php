<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Jual Beli Barang Bekas</title>
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
                
                <!-- Search -->
                <form action="{{ route('home') }}" method="GET" class="flex-1 mx-8">
                    <div class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus"></i> Jual Barang
                        </a>
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Filter Section (Like Shopee) -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-3">
            <form action="{{ route('home') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <!-- Category Filter -->
                <div class="flex items-center">
                    <label class="mr-2 text-gray-600">Kategori:</label>
                    <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Price Range -->
                <div class="flex items-center space-x-2">
                    <label class="text-gray-600">Harga:</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-24 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-400">-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-24 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Condition -->
                <div class="flex items-center">
                    <label class="mr-2 text-gray-600">Kondisi:</label>
                    <select name="condition" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        <option value="baru" {{ request('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="bekas" {{ request('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                    </select>
                </div>
                
                <!-- Location -->
                <div class="flex items-center">
                    <label class="mr-2 text-gray-600">Lokasi:</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Contoh: Jakarta" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Sort -->
                <div class="flex items-center">
                    <label class="mr-2 text-gray-600">Urutkan:</label>
                    <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    </select>
                </div>
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter"></i> Filter
                </button>
                
                <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Products Grid (Facebook Marketplace Style) -->
    <main class="container mx-auto px-4 py-8 flex-grow">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-box-open"></i> Semua Produk
                <span class="text-gray-500 text-sm font-normal">({{ $products->total() }} produk)</span>
            </h2>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Tidak ada produk ditemukan</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden group">
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
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-800 truncate group-hover:text-blue-600">{{ $product->title }}</h3>
                            <p class="text-lg font-bold text-blue-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="flex items-center justify-between mt-2 text-sm text-gray-500">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $product->location }}</span>
                                <span>{{ $product->category->name ?? '-' }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
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
