<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoices(Request $request){

        $invoice = Invoice::with('customers')->orderBy('id', 'DESC')->get();

        return response()->json([
            'invoice' => $invoice
        ], 200);

        $data = [
            'invoice' => $invoice,
            'status' => 200
        ];
        // return response()->json($data);

    }
}
