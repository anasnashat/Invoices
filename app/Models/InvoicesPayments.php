<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesPayments extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'user_id',
        'payment_amount',
        'difference',
        'note'
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
