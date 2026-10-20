<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Dashboard Admin — Ticket Box
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex gap-3 mb-6">
            <a
                href="{{ route('admin.events.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >
                Kelola Konser
            </a>

            <a
                href="{{ route('customer.index') }}"
                class="bg-gray-700 text-white px-4 py-2 rounded"
            >
                Lihat Katalog
            </a>
        </div>

        <div class="bg-white rounded shadow overflow-x-auto p-4">

            <h3 class="font-bold text-xl mb-4">
                Rekap Pesanan Masuk
            </h3>

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-3">ID</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Detail Tiket</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b align-top">

                            <td class="p-3">
                                #{{ $order->id }}
                            </td>

                            <td class="p-3">
                                {{ $order->customer_name }}
                            </td>

                            <td class="p-3">
                                {{ $order->customer_email }}
                            </td>

                            <td class="p-3">
                                @foreach($order->orderDetails as $detail)
                                    <div class="mb-2">
                                        {{ $detail->event->title ?? 'Event tidak tersedia' }}
                                        <br>
                                        {{ $detail->quantity }} tiket
                                        <br>
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </div>
                                @endforeach
                            </td>

                            <td class="p-3 font-bold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            <td class="p-3">
                                {{ $order->status }}
                            </td>

                            <td class="p-3">
                                <form
                                    action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status"
                                        class="border rounded p-2"
                                    >
                                        @foreach(['Pending', 'Confirmed', 'Cancelled'] as $status)
                                            <option
                                                value="{{ $status }}"
                                                @selected($order->status === $status)
                                            >
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white px-3 py-2 rounded mt-2"
                                    >
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>