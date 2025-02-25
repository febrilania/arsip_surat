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
                    <td class="py-2 border border-gray-200 text-center p-4">{{ $suratMasuk->firstItem() + $key }}</td>
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
<div class="mt-4">
    {{ $suratMasuk->links() }}
</div>