<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesPaymentsExport;
use App\Http\Middleware\InvoicesCheckDifferenceMiddleware;
use App\Http\Requests\InvoicesPaymentsRequest;
use App\Models\Invoices;
use App\Models\InvoicesPayments;
use App\Notifications\Invoicepaid;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(Middleware $middleware)
    {
        $middleware->append(InvoicesCheckDifferenceMiddleware::class);
    }

    public function index()
    {

        //


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Invoices $invoices, Request $request)
    {
//        dd($request->invoices->status == 1);
        return view('invoices.store_status', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoicesPaymentsRequest $request, Invoices $invoices)
    {
        $validatedData = $request->validated();
        try {
            if( $invoices->difference > 0 || $invoices->difference == null) {
                DB::beginTransaction();
                $total = $invoices->total;
                $difference = $total - ($request->payment_amount + $invoices->invoice_payment->sum('payment_amount'));
                $validatedData['difference'] = $difference;
                $validatedData['user_id'] = auth()->id();
                $payment = InvoicesPayments::create($validatedData);
                if ($difference <= 0) {
                    $invoices->update(['status' => 1]);
                }else{
                    $invoices->update(['status' => 2]);
                    $invoices->save();
                }
                DB::commit();
                Notification::send(auth()->user(),new Invoicepaid($payment));

                return redirect()->route('invoices.show', $invoices)->with('success', 'تم دفع دفعه الفاتورة بنجاح');
            }else{
                return redirect()->route('invoices.show', $invoices)->with('error', ' الفاتورة مدفوعه بالكامل');

            }


        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('invoices.update', $invoices)->with('error', 'حدث خطا اثناء تعديل الفاتوره');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(InvoicesPayments $invoicesPayments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(  Invoices $invoices ,InvoicesPayments $invoices_payments)
    {
//        dd($invoices_payments);
        return view('invoices.update_status',['invoices'=>$invoices,'payment'=>$invoices_payments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoicesPaymentsRequest $request, Invoices $invoices ,InvoicesPayments $invoices_payments)
    {
        $validatedData = $request->validated();
        try {
            if( $invoices->difference() > 0 || $invoices->difference == null) {

                DB::beginTransaction();
                $total = $invoices->total;
                $difference = $total - ($request->payment_amount + $invoices->invoice_payment->sum('payment_amount'));
//            dd($difference);
//            dd($invoices->total);

                if ($difference <= 0) {
                    $invoices->update(['status' => 1]);
                } else {
                    $validatedData['difference'] = $difference;
                    $validatedData['user_id'] = auth()->id();
                    $invoices_payments->update($validatedData);
                    $invoices->update(['status' => 2]);
                }
                DB::commit();

                return redirect()->route('invoices.show', $invoices)->with('success', 'تم تعديل الفاتورة بنجاح');
            }else{
                return redirect()->route('invoices.show', $invoices)->with('error', ' الفاتورة مدفوعه بالكامل');

            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('invoices.update', $invoices)->with('error', 'حدث خطا اثناء تعديل الفاتوره');
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoicesPayments $invoicesPayments)
    {
        //
    }
    public function export($invoiceId)
    {
        return Excel::download(new InvoicesPaymentsExport($invoiceId),'invoicesPayments.xlsx');
    }
}
