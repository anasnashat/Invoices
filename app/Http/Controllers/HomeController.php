<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @job retern the charts fot the main page in the website with the invoices data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(): View
    {

        $count_all =Invoices::count();
        $count_invoices1 = Invoices::where('status', 1)->count();
        $count_invoices2 = Invoices::where('status', 0)->count();
        $count_invoices3 = Invoices::where('status', 2)->count();

        if($count_invoices2 == 0){
            $nspainvoices2=0;
        }
        else{
            $nspainvoices2 = round(($count_invoices2/ $count_all*100),2);
        }

        if($count_invoices1 == 0){
            $nspainvoices1=0;
        }
        else{
            $nspainvoices1 = round(( $count_invoices1/ $count_all*100),2);
        }

        if($count_invoices3 == 0){
            $nspainvoices3=0;
        }
        else{
            $nspainvoices3 = round(($count_invoices3/ $count_all*100),2);
        }

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices3]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
                ]
            ])
            ->options([]);

        return view('home.index', compact('chartjs','chartjs_2'));

    }
}
