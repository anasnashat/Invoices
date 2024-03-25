<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesPayments extends Model
{
    use HasFactory;

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }
}
