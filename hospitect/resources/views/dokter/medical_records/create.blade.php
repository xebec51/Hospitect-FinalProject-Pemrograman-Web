@extends('layouts.app')

@section('title', 'Tambah Catatan Medis')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Catatan Medis</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.medical-records.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="patient_id" class="block text-gray-700">Nama Pasien:</label>
            <select name="patient_id" id="patient_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Pasien</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="diagnosis" class="block text-gray-700">Diagnosis:</label>
            <textarea name="diagnosis" id="diagnosis" rows="4" class="w-full border-gray-300 rounded p-2" required>{{ old('diagnosis') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="record_date" class="block text-gray-700">Tanggal Periksa:</label>
            <input type="date" name="record_date" id="record_date" value="{{ old('record_date') }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="record_time" class="block text-gray-700">Waktu Periksa:</label>
            <select name="record_time" id="record_time" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Waktu</option>
                @for ($hour = 8; $hour <= 17; $hour++)
                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                    <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-4">
            <label for="treatment" class="block text-gray-700">Tindakan:</label>
            <input type="text" name="treatment" id="treatment" value="{{ old('treatment') }}" class="w-full border-gray-300 rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Obat:</label>
            <div id="medicine-container">
                <div class="medicine-row mb-2 flex items-center">
                    <select name="medicines[0][id]" class="w-1/3 border-gray-300 rounded p-2 mr-2" required>
                        <option value="">Pilih Obat</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="medicines[0][dosage]" placeholder="Dosis" class="w-1/3 border-gray-300 rounded p-2 mr-2" required>
                    <input type="text" name="medicines[0][instructions]" placeholder="Instruksi" class="w-1/3 border-gray-300 rounded p-2 mr-2">
                    <button type="button" class="remove-medicine px-4 py-2 rounded" style="background-color: #dc2626; color: white;">Hapus</button>
                </div>
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
