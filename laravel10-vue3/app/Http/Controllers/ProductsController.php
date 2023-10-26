<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function get_all_products(){

        $products = Products::orderBy('id', 'DESC')->get();

        return response()->json([
            'products' => $products
        ], 200);

    }
}
