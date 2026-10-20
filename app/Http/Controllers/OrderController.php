<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // Menampilkan katalog konser.
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('customer.index', compact('events'));
    }

    // Menyimpan transaksi pemesanan tiket.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ]);

        $items = collect($validated['items'])
            ->filter(fn ($quantity) => $quantity > 0);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu tiket.',
            ]);
        }

        DB::transaction(function () use (
            $validated,
            $items
        ) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'total_price' => 0,
                'status' => 'Pending',
            ]);

            $totalPrice = 0;

            foreach ($items as $eventId => $quantity) {
                $event = Event::findOrFail($eventId);

                $subtotal = $event->ticket_price * $quantity;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'event_id' => $event->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $totalPrice += $subtotal;
            }

            $order->update([
                'total_price' => $totalPrice,
            ]);
        });

        return redirect()
            ->route('customer.index')
            ->with('success', 'Pesanan tiket berhasil dibuat.');
    }

    // Menampilkan rekap pesanan kepada Admin.
    public function adminDashboard()
    {
        $orders = Order::with('orderDetails.event')
            ->latest()
            ->paginate(15);

        return view('admin.dashboard', compact('orders'));
    }

    // Mengubah status pesanan.
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Status pesanan berhasil diperbarui.'
        );
    }
}