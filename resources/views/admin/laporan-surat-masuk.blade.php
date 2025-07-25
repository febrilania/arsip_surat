<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('laporan.surat-masuk.admin.pdf', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}" method="GET">
                        @csrf
                        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">Export PDF</button>
                    </form>

                    <div class="relative overflow-hidden shadow-md rounded-lg my-3">
                        <div class="overflow-x-auto">
                            <table class="table-fixed w-full text-left min-w-max">
                                <thead class="uppercase bg-[#4B5563] text-[#E5E7EB]">
                                    <tr>
                                        <th class="py-3 px-4 border border-gray-200 text-center w-24">No</th>
                                        <th class="py-3 px-4 border border-gray-200 text-center">No Surat</th>
                                        <th class="py-3 px-4 border border-gray-200 text-center">Tanggal Surat</th>
                                        <th class="py-3 px-4 border border-gray-200 text-center">Pengirim</th>
                                        <th class="py-3 px-4 border border-gray-200 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 text-xs md:text-sm">
                                    @forelse ($suratMasuk as $key => $surat)
                                    <tr class="bg-white hover:bg-gray-50 transition duration-200 ease-in-out">
                                        <td class="py-3 px-4 border border-gray-200 text-center">{{  $key + 1 }}</td>
                                        <td class="py-3 px-4 border border-gray-200 text-center">{{ $surat->nomor_surat }}</td>
                                        <td class="py-3 px-4 border border-gray-200 text-center">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</td>
                                        <td class="py-3 px-4 border border-gray-200 text-center">{{ $surat->pengirim }}</td>
                                        <td class="py-3 px-4 border border-gray-200 text-center">{{ $surat->status }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            Tidak ada surat masuk untuk ditampilkan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{-- {{ $suratMasuk->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>