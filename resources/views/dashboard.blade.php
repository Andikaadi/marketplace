<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-store"></i> Marketplace
                </a>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-home"></i> Lihat Produk
                    </a>
                    <div class="flex items-center space-x-2 text-gray-700">
                        <i class="fas fa-user-circle text-xl"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
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

    <!-- Dashboard Content -->
    <main class="container mx-auto px-4 py-8 flex-grow" flex-grow">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-tachometer-alt"></i> Dashboard Saya
            </h1>
            <a href="{{ route('products.create') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-plus"></i> Jual Barang Baru
            </a>
        </div>

        <!-- User Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    <p class="text-gray-600"><i class="fas fa-phone"></i> {{ Auth::user()->phone }}</p>
                </div>
            </div>
        </div>

        <!-- My Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-box-open"></i> Produk Saya ({{ $myProducts->total() }})
                </h2>
            </div>
            <div class="p-6">
                @if($myProducts->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Anda belum memiliki produk</p>
                        <a href="{{ route('products.create') }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-plus"></i> Jual Barang Pertama Anda
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($myProducts as $product)
                        <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
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
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $product->location }}</span>
                                    <span class="text-sm text-gray-400">{{ $product->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex space-x-2 mt-4">
                                    <a href="{{ route('products.edit', $product->id) }}" class="flex-1 text-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Yakin hapus produk ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $myProducts->links() }}
                    </div>
                @endif
            </div>
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
