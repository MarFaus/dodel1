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
        $validated = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'seat_ids'       => 'required|array|min:1|max:6',
            'seat_ids.*'     => 'exists:seats,id',
            'customer_name'  => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Zа-яА-ЯёЁӘәҒғҚқҢңӨөҰұҮүҺһ\s\-]+$/u'
            ],
            'customer_email' => 'required|email|max:255',
            'customer_phone' => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]{10,18}$/'
            ],
            'payment_method' => 'required|in:kaspi,cloud,stripe',
        ], [
            'event_id.required'       => 'Не указано мероприятие.',
            'event_id.exists'         => 'Выбранное мероприятие не найдено.',
            'seat_ids.required'       => 'Выберите хотя бы одно место на схеме.',
            'seat_ids.min'            => 'Выберите хотя бы одно место.',
            'seat_ids.max'            => 'Нельзя забронировать более 6 мест за один раз.',
            'seat_ids.*.exists'       => 'Одно из выбранных мест не существует.',
            'customer_name.required'  => 'Заполните поле ФИО.',
            'customer_name.min'       => 'ФИО должно содержать не менее 2 символов.',
            'customer_name.regex'     => 'ФИО должно содержать только буквы.',
            'customer_email.required' => 'Заполните E-mail.',
            'customer_email.email'    => 'Введите корректный E-mail адрес.',
            'customer_phone.required' => 'Укажите номер телефона.',
            'customer_phone.regex'    => 'Введите корректный номер телефона (не менее 10 цифр).',
            'payment_method.required' => 'Выберите способ оплаты.',
            'payment_method.in'       => 'Недопустимый способ оплаты.',
        ]);

        return DB::transaction(function () use ($validated) {
            $event = Event::findOrFail($validated['event_id']);
            
            // Защита от оверселлинга (пессимистическая блокировка выбранных мест)
            $existingTickets = Ticket::where('event_id', $event->id)
                ->whereIn('seat_id', $validated['seat_ids'])
                ->whereHas('order', function ($q) {
                    $q->where('status', 'paid')
                      ->orWhere(function ($q2) {
                          $q2->where('status', 'pending')->where('expires_at', '>', now());
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

            $seats = Seat::whereIn('id', $validated['seat_ids'])->get();
            $totalAmount = 0;

            foreach ($seats as $seat) {
                $totalAmount += $event->prices[$seat->zone] ?? $event->prices['parter'] ?? 5000;
            }

            $orderNumber = 'ORD-' . rand(10000, 99999);

            $order = Order::create([
                'order_number'   => $orderNumber,
                'event_id'       => $event->id,
                'customer_name'  => trim($validated['customer_name']),
                'customer_email' => trim($validated['customer_email']),
                'customer_phone' => trim($validated['customer_phone']),
                'payment_method' => $validated['payment_method'],
                'total_amount'   => $totalAmount,
                'status'         => 'paid',
                'expires_at'     => now()->addMinutes(15),
            ]);

            foreach ($seats as $seat) {
                $rawCode = 'TP-' . strtoupper(Str::random(8));
                $ticketPrice = $event->prices[$seat->zone] ?? $event->prices['parter'] ?? 5000;

                Ticket::create([
                    'order_id'    => $order->id,
                    'event_id'    => $event->id,
                    'seat_id'     => $seat->id,
                    'ticket_code' => $rawCode,
                    'price'       => $ticketPrice,
                    'is_used'     => false,
                ]);
            }

            return response()->json([
                'success'      => true,
                'order_number' => $order->order_number,
                'redirect'     => route('orders.index')
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
        $order = Order::where('order_number', $id)->firstOrFail();
        
        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
        }

        return redirect()->route('orders.index')->with('warning', "Заказ {$order->order_number} отменён.");
    }
}