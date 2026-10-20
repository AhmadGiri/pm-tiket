<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Edit Konser
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4">

        <form
            action="{{ route('admin.events.update', $event) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow space-y-4"
        >
            @csrf
            @method('PUT')

            <div>
                <label>Nama Konser</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $event->title) }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div>
                <label>Kategori</label>
                <select name="category" class="w-full border rounded p-2">
                    @foreach(['Musik', 'Festival', 'Seminar'] as $category)
                        <option
                            value="{{ $category }}"
                            @selected(old('category', $event->category) === $category)
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Harga Tiket</label>
                <input
                    type="number"
                    name="ticket_price"
                    min="0"
                    value="{{ old('ticket_price', $event->ticket_price) }}"
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
                >{{ old('description', $event->description) }}</textarea>
            </div>

            <div>
                <label>Poster Baru (Opsional)</label>
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
                Update Konser
            </button>
        </form>

    </div>
</x-app-layout>