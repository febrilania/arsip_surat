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
                    <x-primary-button x-data x-on:click="$dispatch('open-modal', 'tambah-kategori-modal')" class="mb-3">
                        Tambah Kategori
                    </x-primary-button>

                    <!-- Modal -->
                    <x-modal name="tambah-kategori-modal" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">
                                Tambah Kategori
                            </h2>

                            <form action="{{ route('kategori-surat.admin.create') }}" method="POST">
                                @csrf
                                <!-- Nama Kategori -->
                                <div class="mb-4">
                                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                    <input type="text" id="nama_kategori" name="nama_kategori"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                        placeholder="Masukkan nama kategori" required>
                                    @error('nama_kategori')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                        placeholder="Masukkan deskripsi kategori" required></textarea>
                                    @error('deskripsi')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        Batal
                                    </x-secondary-button>
                                    <x-primary-button class="ms-3">
                                        Simpan
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </x-modal>


                    <div class="relative overflow-hidden shadow-md rounded-lg">
                        <table class="table-fixed w-full text-left">
                            <thead class="uppercase bg-[#6b7280] text-[#e5e7eb]" style="background-color: #6b7280; color: #e5e7eb;">
                                <tr>
                                    <!--[-->
                                    <td class="py-1 border border-gray-200 text-center p-4 w-16">No</td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">nama kategori</td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">deskripsi</td>
                                    <td contenteditable="true" class="py-1 border border-gray-200 text-center  p-4">aksi</td>
                                    <!--]-->
                                </tr>
                            </thead>
                            <tbody class="bg-white text-gray-500 bg-[#FFFFFF] text-[#6b7280]" style="background-color: #FFFFFF; color: #6b7280;">
                                @foreach ($kategori as $index => $kategor)
                                <!--[-->
                                <tr class=" py-5">
                                    <!--[-->
                                    <td class="py-5 border border-gray-200 text-center p-4 w-16">{{ $index + 1 }}</td>
                                    <td class=" py-5 border border-gray-200 text-center  p-4" contenteditable="false">{{ $kategor->nama_kategori}}</td>
                                    <td class=" py-5 border border-gray-200 text-center  p-4" contenteditable="false">{{ $kategor->deskripsi }}</td>
                                    <td contenteditable="false" class=" py-5 border border-gray-200  text-center p-4">
                                        <x-primary-button x-data x-on:click="$dispatch('open-modal', 'edit-kategori-modal-{{ $kategor->id }}')" class="my-3">
                                            Edit
                                        </x-primary-button>
                                        <x-modal name="edit-kategori-modal-{{ $kategor->id }}" focusable>
                                            <div class="p-6">
                                                <h2 class="text-lg text-start font-medium text-gray-900 mb-4">
                                                    Edit Kategori
                                                </h2>

                                                <form action="{{ route('kategori-surat.admin.update', $kategor->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')  
                                                    <!-- Nama Kategori -->
                                                    <div class="mb-4 text-left">
                                                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                                        <input type="text" id="nama_kategori" name="nama_kategori"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                                            placeholder="Masukkan nama kategori" value="{{ old('nama_kategori', $kategor->nama_kategori) }}" required>
                                                        @error('nama_kategori')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <!-- Deskripsi -->
                                                    <div class="mb-4 text-left">
                                                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                                            placeholder="Masukkan deskripsi kategori" required>{{ old('deskripsi', $kategor->deskripsi) }}</textarea>
                                                        @error('deskripsi')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>
                                                        <x-primary-button class="ms-3">
                                                            Simpan
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>
                                        <form method="POST" action="{{ route('kategori-surat.admin.destroy', $kategor->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button class="my-3" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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