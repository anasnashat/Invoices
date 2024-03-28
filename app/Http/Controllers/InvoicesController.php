<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesRequest;
use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices =QueryBuilder::for(Invoices::class)
            ->allowedFilters(['status'])
            ->with('section')
            ->with('invoice_attachment.user')
            ->with('invoice_payment')->paginate(25);
        return view('invoices.index',compact('invoices'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::with('products')->get();
        return view('invoices.create', ['sections' => $sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoicesRequest $request)
    {

        try {

            DB::beginTransaction();

            $validatedData = $request->validated();
            $validatedData['user_id'] = auth()->id();

            $invoice_created = Invoices::create($validatedData);
//        dd($invoice_created);
            if ($request->file('attachment')) {
                $attachment['invoice_id'] =  $invoice_created->id;
                $attachment['user_id'] = auth()->id();
                $attachmentPath = $request->file('attachment')
                    ->storeAs(
                        'attachment/' . $request->invoice_number,
                        $request->file('attachment')->getClientOriginalName()
                    );
                InvoicesAttachment::create($attachment);

            }




            DB::commit();
            return redirect()->route('invoices.index')->with('success','تم اضافه الفاتوره بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('invoices.index')->with('error','حدث خطا اثناء اضافه الفاتوره');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices $invoice)
    {
        $sections = Section::all();
//        dd($invoices);
        return view('invoices.edite', ['sections'=>$sections, 'invoices'=>$invoice ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoicesRequest $request, Invoices $invoice)
    {
        try {
            $validatedData = $request->validated();

            DB::beginTransaction();

            $invoice->update($validatedData);

            DB::commit();

            return redirect()->route('invoices.show', $invoice)->with('success', 'تم تعديل الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('invoices.edit', $invoice)->with('error', 'حدث خطا اثناء تعديل الفاتوره');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices $invoice)
    {
        try {

            DB::beginTransaction();
//            dd($invoice['invoice_attachment']);
            $invoice->delete();
            DB::commit();
            return redirect()->route('invoices.index')->with('success','تم حذف الفاتوره بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('invoices.index')->with('error','حدث خطا اثناء حذف الفاتوره');
        }
    }
}
