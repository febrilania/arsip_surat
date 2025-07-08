{{-- <x-app-layout>
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
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-6 px-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Chart 1: Surat per bulan --}}
            <div class="bg-white p-4 rounded shadow">
                <canvas id="suratPerBulanChart"></canvas>
            </div>

            {{-- Chart 2: Kategori surat masuk --}}
            <div class="bg-white p-4 rounded shadow">
                <canvas id="kategoriSuratMasukChart"></canvas>
            </div>

            {{-- Chart 3: Status surat masuk --}}
            <div class="bg-white p-4 rounded shadow">
                <canvas id="statusSuratMasukChart"></canvas>
            </div>

            {{-- Chart 4: Status surat keluar --}}
            <div class="bg-white p-4 rounded shadow">
                <canvas id="statusSuratKeluarChart"></canvas>
            </div>

            {{-- Chart 5: Log harian --}}
            <div class="bg-white p-4 rounded shadow col-span-full">
                <canvas id="logHarianChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const months = @json($months);
        const suratMasukData = @json($suratMasukPerBulan);
        const suratKeluarData = @json($suratKeluarPerBulan);

        // Chart 1: Surat Masuk & Keluar per Bulan
        const ctx1 = document.getElementById('suratPerBulanChart');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                        label: 'Surat Masuk',
                        backgroundColor: '#3b82f6',
                        data: months.map((_, i) => suratMasukData[i + 1] || 0),
                    },
                    {
                        label: 'Surat Keluar',
                        backgroundColor: '#10b981',
                        data: months.map((_, i) => suratKeluarData[i + 1] || 0),
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Surat Masuk & Keluar per Bulan (Tahun Ini)',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        // Chart 2: Kategori Surat Masuk
        const ctx2 = document.getElementById('kategoriSuratMasukChart');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {!! json_encode($kategoriMasuk->keys()) !!},
                datasets: [{
                    data: {!! json_encode($kategoriMasuk->values()) !!},
                    backgroundColor: ['#f87171', '#34d399', '#60a5fa', '#fbbf24', '#a78bfa'],
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Kategori Surat Masuk',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        // Chart 3: Status Surat Masuk
        const ctx3 = document.getElementById('statusSuratMasukChart');
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusMasuk->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusMasuk->values()) !!},
                    backgroundColor: ['#facc15', '#3b82f6', '#10b981'],
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Status Surat Masuk',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        // Chart 4: Status Surat Keluar
        const ctx4 = document.getElementById('statusSuratKeluarChart');
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusKeluar->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusKeluar->values()) !!},
                    backgroundColor: ['#facc15', '#3b82f6', '#10b981'],
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Status Surat Keluar',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        // Chart 5: Log Harian
        const logLabels = {!! json_encode($logHarian->keys()) !!};
        const logData = {!! json_encode($logHarian->values()) !!};
        const ctx5 = document.getElementById('logHarianChart');
        new Chart(ctx5, {
            type: 'line',
            data: {
                labels: logLabels,
                datasets: [{
                    label: 'Log Harian',
                    data: logData,
                    fill: true,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Aktivitas Log Harian (7 Hari Terakhir)',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>
