<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!--button modal -->
                    <x-primary-button x-data x-on:click="$dispatch('open-modal', 'example-modal')">
                        Buka Modal
                    </x-primary-button>

                    <!-- modal -->
                    <x-modal name="example-modal" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Konfirmasi Tindakan
                            </h2>
                            <p class="mt-2 text-sm text-gray-600">
                                Apakah kamu yakin ingin melanjutkan aksi ini?
                            </p>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    Batal
                                </x-secondary-button>
                                <x-primary-button class="ms-3">
                                    Lanjutkan
                                </x-primary-button>
                            </div>
                        </div>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>