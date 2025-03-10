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
                    <x-primary-button class="mb-3">
                        Tambah User
                    </x-primary-button>                  

                    <div class="relative overflow-hidden shadow-md rounded-lg">
                        <table class="table-fixed w-full text-left">
                            <thead class="uppercase bg-[#6b7280] text-[#e5e7eb]" style="background-color: #6b7280; color: #e5e7eb;">
                                <tr>
                                    <!--[-->
                                    <td class="py-1 border border-gray-200 text-center p-4 w-16">No</td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">Nama</td>
                                    <td class="py-1 border border-gray-200 text-center  p-4" contenteditable="true">Role</td>
                                    <td contenteditable="true" class="py-1 border border-gray-200 text-center  p-4">aksi</td>
                                    <!--]-->
                                </tr>
                            </thead>
                            <tbody class="bg-white text-gray-500 bg-[#FFFFFF] text-[#6b7280]" style="background-color: #FFFFFF; color: #6b7280;">
                                @foreach ($users as $index => $user)
                                <!--[-->
                                <tr class=" py-5">
                                    <!--[-->
                                    <td class="py-5 border border-gray-200 text-center p-4 w-16">{{ $index + 1 }}</td>
                                    <td class=" py-5 border border-gray-200 text-center  p-4" contenteditable="false">{{ $user->name}}</td>
                                    <td class=" py-5 border border-gray-200 text-center  p-4" contenteditable="false">{{ $user->role }}</td>
                                    <td contenteditable="false" class=" py-5 border border-gray-200  text-center p-4">
                                        <a href="{{route('users.admin.show', $user->id)}}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            Detail
                                        </a>
                                        <a href="{{route('users.admin.edit', $user->id)}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 sm:mt-3">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{route('users.admin.delete', $user->id)}}" class="inline">
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