<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center space-x-4">
                        <!-- Profile Picture -->
                        <img src="{{ asset('storage/'. $user->profile_photo)  }}" 
                             alt="Profile Picture" 
                             class="w-48 h-56 rounded-lg border-4 border-gray-300 object-cover shadow-md">
                        <div>
                            <h3 class="text-2xl font-semibold">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ '@' . $user->username }}</p>
                        </div>
                    </div>

                    <!-- Detail User -->
                    <div class="mt-6">
                        <table class="w-full border-collapse border border-gray-300">
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold bg-gray-100">Nama</td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold bg-gray-100">Username</td>
                                    <td class="px-4 py-2">{{ $user->username }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold bg-gray-100">Email</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold bg-gray-100">Role</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-block bg-blue-500 text-white px-3 py-1 rounded">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-6">
                        <a href="{{ route('users.admin.index') }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
