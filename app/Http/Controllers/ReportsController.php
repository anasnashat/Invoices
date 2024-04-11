<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    /**
     * return to the reports view for invoices section
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */

    public function invoices(): View
    {
       return view('reports.invoices');
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Illuminate\Contracts\
     * @done make filter for the all invoices from date to date and with the invoices number
     */
    public function invoices_filter(Request $request): View
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

    /**
     * @return View with all section information
     *
     */
    public function customers(): View
    {
        $sections = Section::all();
        return view('reports.customers',compact('sections'));
    }

    /**
     * @param Request $request
     * @return View with the filtered invoices from date to date and with the invoice number
     */
    public function customers_filter(Request $request): View
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
