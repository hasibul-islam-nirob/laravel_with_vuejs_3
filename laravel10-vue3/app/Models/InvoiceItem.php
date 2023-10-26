<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'unit_price',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function product(){
        return $this->belongsTo(Products::class);
    }
}
