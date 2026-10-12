<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['order', 'event', 'seat'])->get();
        return view('scan.index', compact('tickets'));
    }

    public function verify(Request $request)
    {
        $request->validate(['ticket_code' => 'required|string']);

        $code = trim($request->ticket_code);
        $ticket = Ticket::with(['order', 'event', 'seat'])->where('ticket_code',$code)->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'status' => 'bad',
                'title' => 'Билет не найден',
                'text' => 'Билет с таким кодом не зарегистрирован в базе данных.'
            ]);
        }

        if ($ticket->order->status !== 'paid') {
            return response()->json([
                'success' => false,
                'status' => 'bad',
                'title' => 'Заказ не оплачен',
                'text' => "Заказ {$ticket->order->order_number} не находится в статусе Оплачен."
            ]);
        }

        if ($ticket->is_used) {
            return response()->json([
                'success' => false,
                'status' => 'used',
                'title' => 'Повторный проход',
                'text' => "Билет уже погашен {$ticket->scanned_at?->format('H:i')}."
            ]);
        }

        $ticket->update([
            'is_used' => true,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'status' => 'ok',
            'title' => 'Проход разрешён',
            'text' => "{$ticket->event->title} · Ряд {$ticket->seat->row_number}, Место {$ticket->seat->seat_number}. Вход отмечен."
        ]);
    }
}