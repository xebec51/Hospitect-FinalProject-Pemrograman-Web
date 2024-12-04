@extends('layouts.app')

@section('title', 'Edit Catatan Medis')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Catatan Medis</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.medical-records.update', $medicalRecord->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="patient_id" class="block text-gray-700">Nama Pasien:</label>
            <select name="patient_id" id="patient_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Pasien</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $medicalRecord->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="diagnosis" class="block text-gray-700">Diagnosis:</label>
            <textarea name="diagnosis" id="diagnosis" rows="4" class="w-full border-gray-300 rounded p-2" required>{{ $medicalRecord->diagnosis }}</textarea>
        </div>

        <div class="mb-4">
            <label for="record_date" class="block text-gray-700">Tanggal Periksa:</label>
            <input type="date" name="record_date" id="record_date" value="{{ $medicalRecord->record_date->format('Y-m-d') }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="treatment" class="block text-gray-700">Tindakan:</label>
            <input type="text" name="treatment" id="treatment" value="{{ $medicalRecord->treatment }}" class="w-full border-gray-300 rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Obat:</label>
            <div id="medicine-container">
                @foreach($medicalRecord->medicines as $index => $medicine)
                    <div class="medicine-row mb-2 flex items-center">
                        <select name="medicines[{{ $index }}][id]" class="w-1/3 border-gray-300 rounded p-2 mr-2" required>
                            <option value="">Pilih Obat</option>
                            @foreach($medicines as $med)
                                <option value="{{ $med->id }}" {{ $medicine->id == $med->id ? 'selected' : '' }}>{{ $med->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="medicines[{{ $index }}][dosage]" placeholder="Dosis" class="w-1/3 border-gray-300 rounded p-2 mr-2" value="{{ $medicine->pivot->dosage }}" required>
                        <input type="text" name="medicines[{{ $index }}][instructions]" placeholder="Instruksi" class="w-1/3 border-gray-300 rounded p-2 mr-2" value="{{ $medicine->pivot->instructions }}">
                        <button type="button" class="remove-medicine px-4 py-2 rounded" style="background-color: #dc2626; color: white;">Hapus</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-medicine" class="px-4 py-2 rounded mt-2" style="background-color: #16a34a; color: white;">Tambah Obat</button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 rounded" style="background-color: #2563eb; color: white;">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-medicine').addEventListener('click', function () {
        const container = document.getElementById('medicine-container');
        const index = container.children.length;
        const newRow = `
            <div class="medicine-row mb-2 flex items-center">
                <select name="medicines[${index}][id]" class="w-1/3 border-gray-300 rounded p-2 mr-2" required>
                    <option value="">Pilih Obat</option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="medicines[${index}][dosage]" placeholder="Dosis" class="w-1/3 border-gray-300 rounded p-2 mr-2" required>
                <input type="text" name="medicines[${index}][instructions]" placeholder="Instruksi" class="w-1/3 border-gray-300 rounded p-2 mr-2">
                <button type="button" class="remove-medicine px-4 py-2 rounded" style="background-color: #dc2626; color: white;">Hapus</button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newRow);
    });

    document.getElementById('medicine-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-medicine')) {
            e.target.closest('.medicine-row').remove();
        }
    });
</script>
@endsection
