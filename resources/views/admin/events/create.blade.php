<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Tambah Konser
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4">

        <form
            action="{{ route('admin.events.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow space-y-4"
        >
            @csrf

            <div>
                <label>Nama Konser</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full border rounded p-2"
                    required
                >
                @error('title')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label>Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Musik">Musik</option>
                    <option value="Festival">Festival</option>
                    <option value="Seminar">Seminar</option>
                </select>
            </div>

            <div>
                <label>Harga Tiket</label>
                <input
                    type="number"
                    name="ticket_price"
                    min="0"
                    value="{{ old('ticket_price') }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div>
                <label>Deskripsi</label>
                <textarea
                    name="description"
                    class="w-full border rounded p-2"
                    required
                >{{ old('description') }}</textarea>
            </div>

            <div>
                <label>Poster Konser</label>
                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png"
                    class="w-full border rounded p-2"
                >
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >
                Simpan Konser
            </button>
        </form>

    </div>
</x-app-layout>