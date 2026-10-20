<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Manajemen Konser
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.events.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Tambah Konser
        </a>

        <div class="overflow-x-auto mt-6 bg-white p-4 rounded shadow">

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-3">Poster</th>
                        <th class="p-3">Nama Konser</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($events as $event)
                        <tr class="border-b">
                            <td class="p-3">
                                @if($event->image)
                                    <img
                                        src="{{ asset('storage/'.$event->image) }}"
                                        alt="{{ $event->title }}"
                                        class="w-20 h-16 object-cover"
                                    >
                                @else
                                    Tidak ada poster
                                @endif
                            </td>

                            <td class="p-3">
                                {{ $event->title }}
                            </td>

                            <td class="p-3">
                                {{ $event->category }}
                            </td>

                            <td class="p-3">
                                Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                            </td>

                            <td class="p-3">
                                <a
                                    href="{{ route('admin.events.edit', $event) }}"
                                    class="text-blue-600"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.events.destroy', $event) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin hapus konser ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center">
                                Belum ada data konser.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $events->links() }}
            </div>

        </div>
    </div>
</x-app-layout>