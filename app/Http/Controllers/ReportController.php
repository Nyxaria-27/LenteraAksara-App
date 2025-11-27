<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function generateInvoice($id)
    {
        $order = Order::with('items.book')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }
}
