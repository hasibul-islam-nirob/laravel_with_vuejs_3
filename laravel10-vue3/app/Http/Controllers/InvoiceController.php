<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function get_all_invoices(){

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


    public function search_invoice(Request $request){
        $search = $request->get('s');

        if ($search != null) {
            $invoice = Invoice::with('customers')
                        ->where('id', 'LIKE', "%$search%")
                        ->get();

            return response()->json([
                'invoice' => $invoice
            ], 200);

        }else{
            return $this->get_all_invoices();
        }

    }

}
