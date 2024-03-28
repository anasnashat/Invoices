<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'user_id',
        'rate_vat',
        'value_vat',
        'amount_commission',
        'discount',
        'total',
        'status',
        'amount_collection',
        'not',
        'payment_date',
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

    public function invoice_payment()
    {
        return $this->hasMany(InvoicesPayments::class, 'invoice_id');
    }
    public function invoice_attachment()
    {
        return $this->hasMany(InvoicesAttachment::class, 'invoice_id');
    }

}
