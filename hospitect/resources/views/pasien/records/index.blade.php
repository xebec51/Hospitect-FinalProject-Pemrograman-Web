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

    <!-- Pencarian -->
    <form method="GET" action="{{ route('pasien.records.index') }}" class="mb-4">
        <div class="flex items-center">
            <input type="text" name="search" class="px-4 py-2 border border-gray-300 rounded w-full md:w-1/3" placeholder="Cari rekam medis..." value="{{ request()->get('search') }}">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>
        </div>
    </form>

    @if ($medicalRecords->isEmpty())
        <p class="text-gray-500">Tidak ada rekam medis yang ditemukan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-200 p-2 text-left">
                            <a href="{{ route('pasien.records.index', ['sort' => 'record_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                Tanggal
                                <i class="ml-2 fas fa-sort{{ request('sort') == 'record_date' ? (request('direction') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th class="border border-gray-200 p-2 text-left">
                            <a href="{{ route('pasien.records.index', ['sort' => 'doctor_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                Dokter
                                <i class="ml-2 fas fa-sort{{ request('sort') == 'doctor_name' ? (request('direction') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th class="border border-gray-200 p-2 text-left">Diagnosis</th>
                        <th class="border border-gray-200 p-2 text-left">Tindakan</th>
                        <th class="border border-gray-200 p-2 text-left">Obat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicalRecords as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 p-2">{{ $record->record_date->format('d/m/Y') }}</td>
                            <td class="border border-gray-200 p-2">{{ $record->doctor->user->name }}</td>
                            <td class="border border-gray-200 p-2">{{ $record->diagnosis }}</td>
                            <td class="border border-gray-200 p-2">{{ $record->treatment ?? 'Tidak ada tindakan' }}</td>
                            <td class="border border-gray-200 p-2">
                                @if($record->medicines->isEmpty())
                                    Tidak ada obat
                                @else
                                    {{ $record->medicines->pluck('name')->implode(', ') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $medicalRecords->links() }}
        </div>
    @endif
</div>
@endsection
