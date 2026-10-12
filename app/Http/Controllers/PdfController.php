<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function download($number)
    {
        $order = Order::with(['event.hall', 'tickets.seat'])
            ->where('order_number', $number)
            ->firstOrFail();

        $secret = env('APP_KEY', 'tp_secret_2026');

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', compact('order', 'secret'));
            return $pdf->download("Ticket_{$order->order_number}.pdf");
        }

        return view('pdf.ticket', compact('order', 'secret'));
    }
}