<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori Surat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!--button modal -->
                    <!-- Tombol untuk membuka modal -->
                    <x-primary-button class="mb-3" onclick="openModal()">
                        Tambah User
                    </x-primary-button>
                    <div class="relative overflow-hidden shadow-md rounded-lg">
                        <table class="table-fixed w-full text-left">
                            <thead class="uppercase bg-[#6b7280] text-[#e5e7eb]"
                                style="background-color: #6b7280; color: #e5e7eb;">
                                <tr>
                                    <!--[-->
                                    <td class="py-1 border border-gray-200 text-center p-4 w-16">No</td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">Nama
                                    </td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">Role
                                    </td>
                                    <td contenteditable="true" class="py-1 border border-gray-200 text-center  p-4">aksi
                                    </td>
                                    <!--]-->
                                </tr>
                            </thead>
                            <tbody class="bg-white text-gray-500 bg-[#FFFFFF] text-[#6b7280]"
                                style="background-color: #FFFFFF; color: #6b7280;">
                                @foreach ($users as $index => $user)
                                    <!--[-->
                                    <tr class=" py-5">
                                        <!--[-->
                                        <td class="py-5 border border-gray-200 text-center p-4 w-16">{{ $index + 1 }}
                                        </td>
                                        <td class=" py-5 border border-gray-200 text-center  p-4"
                                            contenteditable="false">{{ $user->name }}</td>
                                        <td class=" py-5 border border-gray-200 text-center  p-4"
                                            contenteditable="false">{{ $user->role }}</td>
                                        <td contenteditable="false"
                                            class=" py-5 border border-gray-200  text-center p-4">
                                            <a href="{{ route('users.admin.show', $user->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                                Detail
                                            </a>
                                            <a href="{{ route('users.admin.edit', $user->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 sm:mt-3">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('users.admin.delete', $user->id) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button class="my-3"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                    Hapus
                                                </x-danger-button>
                                            </form>
                                        </td>
                                        <!--]-->
                                    </tr>
                                    <!--]-->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal Background -->
<div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <!-- Modal Box -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">Tambah User</h2>

        <!-- Form Tambah User -->
        <form method="POST" action="{{ route('users.admin.create') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" required class="mt-1 p-2 w-full border rounded-md">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>
