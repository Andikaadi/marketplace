<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users - Admin Marketplace</title>
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
                    <span class="text-gray-700">Kelola Users</span>
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
    <main class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-users"></i> Semua Users
                </h2>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-500 text-sm border-b">
                            <th class="pb-3">#</th>
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">No. HP</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">Bergabung</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $index + 1 }}</td>
                            <td class="py-3 font-medium">{{ $user->name }}</td>
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
                            <td class="py-3">
                                @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </main>
</body>
</html>
