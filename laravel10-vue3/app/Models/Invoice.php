<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'customers_id',
        'date',
        'due_date',
        'reference',
        'tre_n_condition',
        'sub_total',
        'discount',
        'total',
        'created_at',
        'updated_at',
    ];

    public function customers(){
        return $this->belongsTo(Customers::class);
    }

    public function invoice_items(){
        return $this->hasMany(InvoiceItem::class);
    }

}
