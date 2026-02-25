<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->title }} - Marketplace</title>
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
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus"></i> Jual Barang
                        </a>
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

    <!-- Product Detail -->
    <main class="container mx-auto px-4 py-8 flex-grow" flex-grow">
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar produk
        </a>
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Image -->
                <div class="md:w-1/2">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-96 md:h-full object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Details -->
                <div class="md:w-1/2 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-3 py-1 text-sm rounded {{ $product->condition == 'baru' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                            {{ $product->condition == 'baru' ? 'Baru' : 'Bekas' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-eye"></i> {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->title }}</h1>
                    <p class="text-3xl font-bold text-blue-600 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <div class="flex items-center text-gray-600 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $product->location }}</span>
                    </div>
                    
                    <div class="border-t border-b py-4 mb-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Deskripsi</h3>
                        <p class="text-gray-600 whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                    
                    <!-- Seller Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Informasi Penjual</h3>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold mr-3">
                                {{ substr($product->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold">{{ $product->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $product->user->phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- WhatsApp Button -->
                    @auth
                        @if(Auth::id() !== $product->user_id)
                            @php
                                $phone = $product->user->phone;
                                // Format nomor: jika dimulai dengan 0, ganti dengan 62
                                if (substr($phone, 0, 1) === '0') {
                                    $phone = '62' . substr($phone, 1);
                                } elseif (substr($phone, 0, 1) !== '62') {
                                    $phone = '62' . $phone;
                                }
                            @endphp
                            <a href="https://wa.me/{{ $phone }}?text=Halo%20{{ urlencode($product->user->name) }},%20saya%20tertarik%20dengan%20{{ urlencode($product->title) }}%20seharga%20Rp%20{{ number_format($product->price, 0, ',', '.') }}" 
                               target="_blank"
                               class="block w-full text-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                            </a>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center text-yellow-700">
                                <i class="fas fa-info-circle"></i> Ini adalah produk Anda
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            <i class="fab fa-whatsapp"></i> Login untuk menghubungi seller
                        </a>
                    @endauth
                    
                    <p class="text-xs text-gray-400 mt-4 text-center">
                        Diposting {{ $product->created_at->diffForHumans() }}
                    </p>
                </div>
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
