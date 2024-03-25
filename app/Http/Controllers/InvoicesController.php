<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesRequest;
use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices =Invoices::with('product')
            ->with('section')
            ->with('invoice_attachment.user')
            ->with('invoice_payment')->paginate(25);
//        dd($invoices);
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
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        $invoice_created = Invoices::create($validatedData);
//        dd($invoice_created);
        $attachment['invoice_id'] =  $invoice_created->id;
        $attachment['user_id'] = auth()->id();
//        dd($request->attachment->getClientOriginalName());
        $attachment['attachment'] = $request->file('attachment')
            ->storeAs(
                'attachment/' . $request->invoice_number,
                $request->attachment->getClientOriginalName()
            );
        InvoicesAttachment::create($attachment);


        try {

            DB::beginTransaction();


            DB::commit();
            return redirect()->route('invoices.create')->with('success','تم اضافه الفاتوره بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('invoices.create')->with('error','حدث خطا اثناء اضافه الفاتوره');
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
    public function edit(Invoices $invoices)
    {
        $sections = Section::all();
//        dd($invoices);
        return view('invoices.edite', ['sections'=>$sections, 'invoices'=>$invoices ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices $invoices)
    {
        //
    }
}
