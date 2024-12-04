@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard Dokter</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut pasien terbaru yang telah diperiksa.</p>

    @if($recentMedicalRecords->isEmpty())
        <p class="mt-4 text-gray-600">Belum ada pasien yang diperiksa.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            @foreach($recentMedicalRecords as $record)
                <div class="p-6 bg-blue-200 rounded shadow hover:shadow-lg transition-shadow duration-300">
                    <p><strong><i class="fas fa-user mr-2"></i>Nama Pasien:</strong> {{ $record->patient->user->name ?? 'Tidak diketahui' }}</p>
                    <p><strong><i class="fas fa-procedures mr-2"></i>Tindakan:</strong> {{ $record->treatment ?? 'Tidak ada tindakan' }}</p>
                    <p><strong><i class="fas fa-calendar-alt mr-2"></i>Tanggal:</strong> {{ $record->record_date->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Visualisasi Data</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="chart-container">
                <h3 class="text-lg font-semibold mb-2">Grafik Rekam Medis Setahun Terakhir</h3>
                <canvas id="medicalRecordsChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="text-lg font-semibold mb-2">Grafik Jadwal Konsultasi Setahun Terakhir</h3>
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const medicalRecordsChartCtx = document.getElementById('medicalRecordsChart').getContext('2d');
        const appointmentsChartCtx = document.getElementById('appointmentsChart').getContext('2d');

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
