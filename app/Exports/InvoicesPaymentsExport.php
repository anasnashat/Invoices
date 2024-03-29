<?php

namespace App\Exports;

use App\Models\InvoicesPayments;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesPaymentsExport implements FromCollection
{
    protected $invoiceId;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    public function collection()
    {
        return InvoicesPayments::where('invoice_id','=',$this->invoiceId)->get();
    }
}
