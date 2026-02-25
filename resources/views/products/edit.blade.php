<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Marketplace</title>
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
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
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

    <!-- Edit Product Form -->
    <main class="container mx-auto px-4 py-8" flex-grow">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-edit"></i> Edit Produk
                </h1>
                
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Nama Produk *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-semibold mb-2">Kategori *</label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-semibold mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Condition -->
                    <div class="mb-4">
                        <label for="condition" class="block text-gray-700 font-semibold mb-2">Kondisi *</label>
                        <select name="condition" id="condition" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="baru" {{ $product->condition == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ $product->condition == 'bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 font-semibold mb-2">Lokasi *</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $product->location) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi *</label>
                        <textarea name="description" id="description" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Current Image -->
                    @if($product->image)
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Foto Saat Ini</label>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                    @endif
                    
                    <!-- Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Ganti Foto Produk</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-gray-500 text-sm mt-1">Maksimal 2MB. Format: JPG, PNG</p>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-center">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
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
