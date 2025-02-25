<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surat Keluar') }}
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
                    <div class="flex justify-between items-center">
                        <a href="{{ route('surat-keluar.admin.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">
                            {{ __('Tambah Surat Keluar') }}
                        </a>
                        <input type="text" id="search" class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mt-4" placeholder="Cari Surat Keluar...">
                    </div>
                    <div id="table-container">
                        @include('admin.partial.surat-keluar.table')
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('surat-keluar.admin.search') }}",
                type: "GET",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#table-container').html(data.html);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>