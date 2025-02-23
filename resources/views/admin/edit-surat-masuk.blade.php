<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('surat-masuk.admin.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- No Surat -->
                        <div class="mb-4">
                            <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor surat</label>
                            <input type="text" id="nomor_surat" name="nomor_surat" value="{{ $suratMasuk->nomor_surat }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                placeholder="Masukkan No Surat" required>
                            @error('nomor_surat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Pengirim -->
                        <div class="mb-4">
                            <label for="pengirim" class="block text-sm font-medium text-gray-700">Pengirim Surat</label>
                            <input type="text" id="pengirim" name="pengirim" value="{{ $suratMasuk->pengirim }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                placeholder="Masukkan Pengirim Surat" required>
                            @error('pengirim')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penerima -->
                        <div class="mb-4">
                            <label for="penerima" class="block text-sm font-medium text-gray-700">Penerima Surat</label>
                            <input type="text" id="penerima" name="penerima" value="{{ $suratMasuk->penerima }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                placeholder="Masukkan Penerima Surat" required>
                            @error('penerima')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Perihal -->
                        <div class="mb-4">
                            <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal Surat</label>
                            <input type="text" id="perihal" name="perihal" value="{{ $suratMasuk->perihal }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                placeholder="Masukkan Perihal Surat" required>
                            @error('perihal')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tanggal Surat -->
                        <div class="mb-4">
                            <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                            <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ $suratMasuk->tanggal_surat }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                required>
                            @error('tanggal_surat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tanggal terima surat -->
                        <div class="mb-4">
                            <label for="tanggal_terima" class="block text-sm font-medium text-gray-700">Tanggal Terima Surat</label>
                            <input type="date" id="tanggal_terima" name="tanggal_terima" value="{{ $suratMasuk->tanggal_terima }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                required>
                            @error('tanggal_terima')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kategori Surat -->
                        <div class="mb-4">
                            <label for="kategori_surat_id" class="block text-sm font-medium text-gray-700">Kategori Surat</label>
                            <select id="kategori_surat_id" name="kategori_surat_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                required>
                                <option value="">Pilih Kategori Surat</option>
                                @foreach ($kategoriSurat as $kategori)
                                <option value="{{ $kategori->id }}" {{ $suratMasuk->kategori_surat_id == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_surat_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Surat -->
                        <div class="mb-4">
                            <label for="file_surat" class="block text-sm font-medium text-gray-700">File Surat</label>
                            <input type="file" id="file_surat" name="file_surat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('file_surat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Surat</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                required>
                                <option value="">Pilih Status Surat</option>
                                <option value="diterima" {{ old('status', $suratMasuk->status ?? '') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="diproses" {{ old('status', $suratMasuk->status ?? '') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ old('status', $suratMasuk->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>

                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Isi Ringkas -->
                            <div class="my-4">
                                <label for="isi_ringkas" class="block text-sm font-medium text-gray-700">Isi Ringkas</label>
                                <textarea id="isi_ringkas" name="isi_ringkas"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                    placeholder="Masukkan Isi Ringkas Surat" required>{{ $suratMasuk->isi_ringkas }}</textarea>
                                @error('isi_ringkas')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items
                        -center justify-end mt-4">
                                <a href="{{route('surat-masuk.admin.index')}}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">Batal</a>
                                <x-primary-button class="ml-4">
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>