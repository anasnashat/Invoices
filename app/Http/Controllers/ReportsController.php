<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\Section;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ReportsController extends Controller
{

    public function invoices()
    {
       return view('reports.invoices');
    }
    public function invoices_filter(Request $request)
    {

        $query = Invoices::query();

        if ($request->radio == 1) {
            if ($request->filled(['start_at', 'end_at'] != '')) {
                $query->whereBetween('invoice_date', [$request->start_at, $request->end_at]);
            }

            if ($request->filled('status') != null) {
                $query->where('status', $request->status);
            }
        } else {
            $query->where('invoice_number', $request->invoice_number);
        }


        $invoices = $query->get();
//        dd($query, $invoices,$request);

        return view('reports.invoices', compact('invoices'));

    }
    public function customers()
    {
        $sections = Section::all();
        return view('reports.customers',compact('sections'));
    }
    public function customers_filter(Request $request)
    {

        $sections = Section::all();

        $query = Invoices::query();

            if ($request->filled(['start_at', 'end_at'] != '')) {
                $query->whereBetween('invoice_date', [$request->start_at, $request->end_at]);
            }

            if ($request->filled('section_id') != '') {
                $query->where('section_id', $request->section_id);
            }

            if ($request->filled('product_id') != '') {
                $query->where('product_id', $request->product_id);
            }


            $invoices = $query->get();
//            dd($invoices,$request);

        return view('reports.customers', ['invoices' => $invoices,'sections'=>$sections]);

    }




}
