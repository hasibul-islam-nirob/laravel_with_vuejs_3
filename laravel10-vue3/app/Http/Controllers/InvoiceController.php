<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
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

    public function show_invoice($id){
        $invoice = Invoice::with(['customers', 'invoice_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice
        ], 200);
    }


    public function edit_invoice($id){
        $invoice = Invoice::with(['customers', 'invoice_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice
        ], 200);
    }

    public function delete_invoice_items($id){
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->delete();
    }

    public function update_invoice(Request $request, $id){

        // dd($request->all(), $id, $request->invoice_item);

        $invoice = Invoice::where('id',$id)->first();

        $invoice->customers_id  = $request->customer_id;
        $invoice->date          = $request->date;
        $invoice->due_date      = $request->due_date;
        $invoice->number        = $request->number;
        $invoice->reference      = $request->referece;
        $invoice->discount      = $request->discount;
        $invoice->sub_total      = $request->subtotal;
        $invoice->total          = $request->total;
        $invoice->tre_n_condition = $request->tre_n_condition;

        $invoice->update($request->all());

        $invoiceItem = $request->invoice_item;

        $invoice->invoice_items()->delete();
        foreach(json_decode($invoiceItem) as $item){
            $itemData['product_id'] = $item->product_id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }

    }

    public function add_invoice(Request $request){

        // dd($request->all());
        $invoiceItem = $request->input('invoice_item');

        $invoiceData['subtotal'] = $request->input('subtotal');
        $invoiceData['toal'] = $request->input('toal');
        $invoiceData['customers_id'] = $request->input('customer_id');
        $invoiceData['number'] = $request->input('number');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['referece'] = $request->input('referece');
        $invoiceData['tre_n_condition'] = $request->input('tre_n_condition');

        $invoice = Invoice::create($invoiceData);


        foreach(json_decode($invoiceItem) as $item){
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }

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
