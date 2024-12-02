@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Ini adalah halaman dashboard admin.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="p-6 bg-blue-200 rounded shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Pengguna</h2>
            <p class="text-2xl">{{ $totalUsers }}</p>
        </div>
        <div class="p-6 bg-green-200 rounded shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Obat</h2>
            <p class="text-2xl">{{ $activeMedicines }}</p>
        </div>
        <div class="p-6 bg-yellow-200 rounded shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Rekam Medis</h2>
            <p class="text-2xl">{{ $totalReports }} laporan</p>
        </div>
        <div class="p-6 bg-purple-200 rounded shadow hover:shadow-lg transition-shadow duration-300">
            <h2 class="text-lg font-semibold">Total Jadwal Konsultasi</h2>
            <p class="text-2xl">{{ $totalAppointments }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Visualisasi Data</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="chart-container">
                <h3 class="text-lg font-semibold mb-2">Jumlah Pengguna Berdasarkan Peran</h3>
                <canvas id="usersChart"></canvas>
            </div>
            <div class="chart-container flex items-center">
                <div class="w-1/2">
                    <h3 class="text-lg font-semibold mb-2">Jenis Obat</h3>
                    <canvas id="medicinesChart"></canvas>
                </div>
                <div class="w-1/2 pl-4">
                    <ul>
                        <li><span class="inline-block w-4 h-4 mr-2" style="background-color: #ff6384;"></span>Tablet</li>
                        <li><span class="inline-block w-4 h-4 mr-2" style="background-color: #36a2eb;"></span>Kapsul</li>
                        <li><span class="inline-block w-4 h-4 mr-2" style="background-color: #ffcd56;"></span>Sirup</li>
                        <li><span class="inline-block w-4 h-4 mr-2" style="background-color: #4bc0c0;"></span>Injeksi</li>
                    </ul>
                </div>
            </div>
            <div class="chart-container">
                <h3 class="text-lg font-semibold mb-2">Rekam Medis dalam Setahun Terakhir</h3>
                <canvas id="medicalRecordsChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="text-lg font-semibold mb-2">Jadwal Konsultasi dalam Setahun Terakhir</h3>
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usersChartCtx = document.getElementById('usersChart').getContext('2d');
        const medicinesChartCtx = document.getElementById('medicinesChart').getContext('2d');
        const medicalRecordsChartCtx = document.getElementById('medicalRecordsChart').getContext('2d');
        const appointmentsChartCtx = document.getElementById('appointmentsChart').getContext('2d');

        const usersChart = new Chart(usersChartCtx, {
            type: 'bar',
            data: {
                labels: ['Admin', 'Dokter', 'Pasien'],
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: [{{ $adminCount }}, {{ $dokterCount }}, {{ $pasienCount }}],
                    backgroundColor: ['#4caf50', '#2196f3', '#ff9800'],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const medicinesChart = new Chart(medicinesChartCtx, {
            type: 'pie',
            data: {
                datasets: [{
                    label: 'Jenis Obat',
                    data: [{{ $tabletCount }}, {{ $kapsulCount }}, {{ $sirupCount }}, {{ $injeksiCount }}],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0'],
                }]
            },
            options: {
                responsive: true
            }
        });

        const medicalRecordsChart = new Chart(medicalRecordsChartCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Rekam Medis',
                    data: {!! json_encode($medicalRecordsData) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const appointmentsChart = new Chart(appointmentsChartCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Jadwal Konsultasi',
                    data: {!! json_encode($appointmentsData) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
