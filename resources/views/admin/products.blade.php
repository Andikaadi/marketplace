<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Products - Admin Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.index') }}" class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-store"></i> Admin
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-700">Kelola Products</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-home"></i> Website
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

    <!-- Content -->
    <main class="container mx-auto px-4 py-8" flex-grow">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-box-open"></i> Semua Products
                </h2>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 text-sm border-b">
                            <th class="pb-3">#</th>
                            <th class="pb-3">Foto</th>
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Penjual</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Kondisi</th>
                            <th class="pb-3">Lokasi</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $index + 1 }}</td>
                            <td class="py-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 font-medium">{{ $product->title }}</td>
                            <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3">{{ $product->user->name }}</td>
                            <td class="py-3">{{ $product->category->name ?? '-' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded {{ $product->condition == 'baru' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                    {{ $product->condition == 'baru' ? 'Baru' : 'Bekas' }}
                                </span>
                            </td>
                            <td class="py-3 text-sm">{{ $product->location }}</td>
                            <td class="py-3">
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin hapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>
</body>
</html>
