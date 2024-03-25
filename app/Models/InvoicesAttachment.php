<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','invoice_id','attachment'];
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
