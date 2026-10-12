<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'seat_ids' => 'required|array|min:1|max:6',
            'seat_ids.*' => 'exists:seats,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'payment_method' => 'required|in:kaspi,cloud,stripe',
        ]);

        return DB::transaction(function () use ($request) {
            $event = Event::findOrFail($request->event_id);
            
            $existingTickets = Ticket::where('event_id',$event->id)
                ->whereIn('seat_id', $request->seat_ids)
                ->whereHas('order', function ($q) {$q->where('status', 'paid')
                      ->orWhere(function ($q2) {$q2->where('status', 'pending')->where('expires_at', '>', now());
                      });
                })
                ->lockForUpdate()
                ->exists();

            if ($existingTickets) {
                return response()->json([
                    'success' => false,
                    'message' => 'Одно или несколько выбранных мест уже забронированы или куплены.'
                ], 422);
            }

            $seats = Seat::whereIn('id', $request->seat_ids)->get();$totalAmount = 0;

            foreach ($seats as$seat) {
                $totalAmount +=$event->prices[$seat->zone] ?? $event->prices['parter'] ?? 5000;
            }

            $orderNumber = 'ORD-' . rand(1000, 9999);

            $order = Order::create([
                'order_number' => $orderNumber,
                'event_id' => $event->id,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'payment_method' => $request->payment_method,
                'total_amount' => $totalAmount,
                'status' => 'paid',
                'expires_at' => now()->addMinutes(15),
            ]);

            $secret = env('APP_KEY', 'tp_secret_2026');

            foreach ($seats as $seat) {$rawCode = 'TP-' . strtoupper(Str::random(6));
                $ticketPrice =$event->prices[$seat->zone] ?? $event->prices['parter'] ?? 5000;

                Ticket::create([
                    'order_id' => $order->id,
                    'event_id' => $event->id,
                    'seat_id' => $seat->id,
                    'ticket_code' => $rawCode,
                    'price' => $ticketPrice,
                    'is_used' => false,
                ]);
            }

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'redirect' => route('orders.index')
            ]);
        });
    }

    public function index()
    {
        $orders = Order::with(['event', 'tickets.seat'])->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function cancel($id)
    {
        $order = Order::where('order_number',$id)->firstOrFail();
        
        if ($order->status === 'pending') {$order->update(['status' => 'cancelled']);
        }

        return redirect()->route('orders.index')->with('warning', "Заказ {$order->order_number} отменён.");
    }
}