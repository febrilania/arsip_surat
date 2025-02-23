<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('surat-masuk.admin.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">
                        {{ __('Tambah Surat Masuk') }}
                    </a>
                    <div class="relative overflow-hidden shadow-md rounded-lg my-3">
                        <div class="overflow-x-auto">
                            <table class="table-fixed w-full text-left min-w-max">
                                <thead class="uppercase bg-[#6b7280] text-[#e5e7eb]">
                                    <tr>
                                        <th class="py-2 border border-gray-200 text-center p-4 w-16">No</th>
                                        <th class="py-2 border border-gray-200 text-center p-4">No Surat</th>
                                        <th class="py-2 border border-gray-200 text-center p-4">Pengirim</th>
                                        <th class="py-2 border border-gray-200 text-center p-4">Perihal</th>
                                        <th class="py-2 border border-gray-200 text-center p-4">Status</th>
                                        <th class="py-2 border border-gray-200 text-center p-4">Kategori Surat</th>
                                        <th class="py-2 border border-gray-200 text-center p-4 w-32">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 text-xs md:text-sm">
                                    @foreach ($suratMasuk as $key => $surat)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $key + 1 }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $surat->nomor_surat }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $surat->pengirim }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $surat->perihal }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $surat->status }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4">{{ $surat->kategoriSurat->nama_kategori }}</td>
                                        <td class="py-2 border border-gray-200 text-center p-4 w-32">
                                            <div class="flex flex-col gap-1">
                                                <a href="{{route('surat-masuk.admin.show', $surat->id)}}" class="block text-center px-2 py-1 bg-green-500 border border-gray-300 rounded-md text-gray-100 text-xs md:text-sm hover:bg-green-400">
                                                    Detail
                                                </a>
                                                <a href="{{route('surat-masuk.admin.edit',$surat->id)}}" class="block text-center px-2 py-1 bg-gray-500 text-white rounded-md text-xs md:text-sm hover:bg-gray-700">
                                                    Edit
                                                </a>
                                                <form action="{{route('surat-masuk.admin.destroy', $surat->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block text-center w-full px-2 py-1 bg-red-600 text-white rounded-md text-xs md:text-sm hover:bg-red-500" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>