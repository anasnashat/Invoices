<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'invoices_number',
        'invoices_date',
        'due_date',
        'product',
        'section',
        'rate_value',
        'value_vat',
        'total',
        'status',
        'note',
        'deleted_at',
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function product(){
        return $this->hasOne(Product::class,'id');
    }


}
