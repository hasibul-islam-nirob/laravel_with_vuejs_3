<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Counter;
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

    public function create_invoice(Request $request){

        $counter = Counter::where('key','invoice')->first();
        $random = Counter::where('key','invoice')->first();

        $invoice = Invoice::orderBy('id','DESC')->first();
        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        }else{
            $counters = $counter->value;
        }
        
        $formData = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'tre_n_condition' =>'Deafult',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1,
                ]
            ]
        ];

        return response()->json($formData);
    }

}
