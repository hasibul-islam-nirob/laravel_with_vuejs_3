<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function get_all_customers(){

        $customers = Customers::orderBy('id', 'DESC')->get();

        return response()->json([
            'customers' => $customers
        ], 200);

    }
}
