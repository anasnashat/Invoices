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

    public function section()
    {
        return $this->belongsTo(Section::class)->withDefault(['section_id' => 'deleted_section']);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault(['id' => 'deleted_product']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
