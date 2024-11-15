<!-- D:\GitHub\Hospitect-FinalProject-Pemrograman-Web\hospitect\resources\views\pasien\records\index.blade.php -->

@extends('layouts.app')

@section('title', 'Rekam Medis Saya')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Rekam Medis Saya</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-200 p-2 text-left">Tanggal Periksa</th>
                <th class="border border-gray-200 p-2 text-left">Dokter</th>
                <th class="border border-gray-200 p-2 text-left">Tindakan</th>
                <th class="border border-gray-200 p-2 text-left">Obat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medicalRecords as $record)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($record->tanggal_periksa)->format('d M Y') }}</td>
                    <td class="border border-gray-200 p-2">{{ $record->dokter->name ?? 'Tidak diketahui' }}</td>
                    <td class="border border-gray-200 p-2">{{ $record->tindakan }}</td>
                    <td class="border border-gray-200 p-2">
                        @if (is_array($record->obat) && !empty($record->obat))
                            <ul>
                                @foreach ($record->obat as $medicine)
                                    <li>{{ $medicine }}</li>
                                @endforeach
                            </ul>
                        @else
                            Tidak ada
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-4">Tidak ada rekam medis yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
