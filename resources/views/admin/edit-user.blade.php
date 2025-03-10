<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('users.admin.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block font-semibold">Nama</label>
                            <input type="text" name="name" value="{{ $user->name }}" 
                                   class="w-full border p-2 rounded mt-1" required>
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <label class="block font-semibold">Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" 
                                   class="w-full border p-2 rounded mt-1" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block font-semibold">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" 
                                   class="w-full border p-2 rounded mt-1" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label class="block font-semibold">Role</label>
                            <select name="role" class="w-full border p-2 rounded mt-1">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block font-semibold">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="w-full border p-2 rounded mt-1">
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-4">
                            <label class="block font-semibold">Foto Profil</label>
                            <input type="file" name="profile_photo" class="w-full border p-2 rounded mt-1">
                            @if ($user->profile_photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'. $user->profile_photo) }}" class="w-24 h-24 rounded-full">
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mt-6 flex space-x-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('users.admin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
