<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <strong class="text-gray-700">Nomor Surat:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->nomor_surat }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Pengirim:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->pengirim }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Penerima:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->penerima }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Perihal:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->perihal }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Tanggal Surat:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($suratMasuk->tanggal_surat)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Tanggal Terima:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($suratMasuk->tanggal_terima)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Kategori Surat:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->kategoriSurat->nama_kategori }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Status:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ ucfirst($suratMasuk->status) }}</p>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <strong class="text-gray-700">Isi Ringkas:</strong>
                        <p class="text-lg font-semibold text-gray-900 bg-gray-100 p-3 rounded-md mt-2">{{ $suratMasuk->isi_ringkas ?? '-' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700">Pembuat:</strong>
                        <p class="text-lg font-semibold text-gray-900">{{ $suratMasuk->Pembuat->name ?? 'Tidak ditemukan' }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <strong class="text-gray-700">File Surat:</strong>
                        @if($suratMasuk->file_surat)
                            <a href="{{ asset('storage/' . $suratMasuk->file_surat) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @else
                            <p>-</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('surat-masuk.admin.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md shadow-sm hover:bg-gray-300">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
