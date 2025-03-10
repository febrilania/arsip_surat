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
                    <h3 class="text-2xl font-semibold">
                        Selamat datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Anda login sebagai <span class="font-bold">{{ ucfirst(Auth::user()->role) }}</span>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>