@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold"><i class="fas fa-notes-medical mr-2"></i>Catatan Medis</h1>
        <a href="{{ route('dokter.medical-records.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Catatan Medis
        </a>
    </div>

    <!-- Pencarian -->
    <form action="{{ route('dokter.medical-records.index') }}" method="GET" class="mb-4 flex">
        <input type="text" name="search" placeholder="Cari Nama Pasien atau Diagnosis" class="p-2 border border-gray-300 rounded-l-md" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md flex items-center">
            <i class="fas fa-search mr-2"></i> Cari
        </button>
    </form>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <!-- Sorting Nama Pasien -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('dokter.medical-records.index', ['sort_by' => 'patient_name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Nama Pasien
                            @if (request('sort_by') === 'patient_name')
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Sorting Diagnosis -->
                    <th class="border border-gray-200 p-2 text-left">Diagnosis</th>
                    <!-- Sorting Tanggal Periksa -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('dokter.medical-records.index', ['sort_by' => 'record_date', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Tanggal Periksa
                            @if (request('sort_by') === 'record_date')
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Tindakan</th>
                    <th class="border border-gray-200 p-2 text-left">Obat</th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicalRecords as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ $record->patient ? $record->patient->user->name : 'Tidak diketahui' }}</td>
                        <td class="border border-gray-200 p-2">{{ $record->diagnosis }}</td>
                        <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</td>
                        <td class="border border-gray-200 p-2">{{ $record->treatment ?? 'Tidak ada tindakan' }}</td>
                        <td class="border border-gray-200 p-2">
                            @if ($record->medicines->isNotEmpty())
                                <ul>
                                    @foreach ($record->medicines as $medicine)
                                        <li>
                                            {{ $medicine->name }} ({{ $medicine->pivot->dosage ?? 'Tidak ada dosis' }},
                                            {{ $medicine->pivot->instructions ?? 'Tidak ada instruksi' }})
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                Tidak ada obat
                            @endif
                        </td>
                        <td class="border border-gray-200 p-2 flex space-x-2">
                            <a href="{{ route('dokter.medical-records.edit', $record->id) }}" class="text-blue-600 hover:underline flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('dokter.medical-records.destroy', $record->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline flex items-center" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">Tidak ada catatan medis yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
