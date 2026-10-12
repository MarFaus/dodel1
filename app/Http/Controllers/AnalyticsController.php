<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $events = Event::with('hall')->get();
        
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');$totalSoldTickets = Ticket::whereHas('order', function ($q) {$q->where('status', 'paid');
        })->count();

        $paidOrders = Order::with('event')->where('status', 'paid')->orderBy('created_at', 'desc')->get();

        return view('analytics.index', compact('events', 'totalRevenue', 'totalSoldTickets', 'paidOrders'));
    }

    public function refund($number)
    {
        $order = Order::where('order_number', $number)->firstOrFail();$order->update(['status' => 'refunded']);

        return redirect()->route('analytics.index')->with('success', "Возврат по заказу {$number} успешно проведен.");
    }
}