@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <!--Internal  treeview -->
    <link href="{{asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title','الفواتير')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                @if(request()->get('filter'))
                @if(request()->get('filter')['status'] == 1)
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير المدفوعه</span>
                @elseif(request()->get('filter')['status'] == 0)

                    <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الغير مدفوعه</span>
                @elseif(request()->get('filter')['status'] == 2)

                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه المدفوعه جزئبا</span>
                    @else
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير</span>
                @endif
                @endif

            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @include('partials.alerts')
                    <div class="d-flex justify-content-between">
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xl-3 justify-content-between">
                    <a class="modal-effect btn btn-success btn-block d-flex justify-content-between align-items-center"   href="{{ route('invoices.create') }}">
                        <span class="mr-2">اضافه فاتوره</span> <!-- Text -->
                        <i class="fas fa-plus-circle ml-2"></i> <!-- Icon -->
                    </a>
                    <a class="modal-effect btn btn-success btn-block d-flex justify-content-between align-items-center"   href="{{ route('invoices.export') }}">
                        <span class="mr-2">تصدير الي اكسيل</span> <!-- Text -->
                        <i class="fas fa-file-excel ml-2"></i> <!-- Icon -->
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0"> رقم الفاتوره </th>
                                <th class="border-bottom-0"> تاريخ الفاتوره </th>
                                <th class="border-bottom-0"> تاريخ الاستحقاق </th>
                                <th class="border-bottom-0">المنتج </th>
                                <th class="border-bottom-0">القسم </th>
                                <th class="border-bottom-0"> نسبه الضريبه </th>
                                <th class="border-bottom-0"> قيمه الضريبه </th>
                                <th class="border-bottom-0"> حاله الفاتوره </th>
                                <th class="border-bottom-0"> الاجمالي  </th>
                                <th class="border-bottom-0"> ملاحظات </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>

                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>{{ $invoice['product']->product_name }}</td>
                                    <td><a href="{{ route('invoices.show',$invoice) }}">{{ $invoice['section']->name }}</a></td>
                                    <td>{{$invoice->rate_vat}}</td>
                                    <td>{{$invoice->value_vat}}</td>
                                    <td
                                        class="{{ $invoice->status == 1 ? 'text-success' :
                                            ($invoice->status == 2 ? 'text-warning' :
                                             'text-danger') }}"
                                    >
                                        {{ $invoice->status == 1 ? 'الفاتورة مدفوعة' : ($invoice->status == 2 ? 'الفاتورة مدفوعة جزئياً' : 'الفاتورة غير مدفوعة') }}
                                    </td>                                    <td>{{$invoice->total}}</td>
                                    <td>{{$invoice->not}}</td>
                                    <td>
                                        <div class="d-flex justify-content-between align-content-center">
                                            <div class="mr-3">
{{--                                                @dd($invoice)--}}
                                                <a class="modal-effect btn btn-outline-primary btn-sm d-flex justify-content-between align-items-center"  href="{{ route('invoices.edit',$invoice) }}" >
                                                    <span>تعديل</span>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="mr-3">
                                                <a class="modal-effect btn btn-outline-primary btn-sm d-flex justify-content-between align-items-center"  href="{{ route('payment.create',$invoice) }}" >
                                                    <span> دفع الفاتوره</span>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="mr-3">
                                                <a class="modal-effect btn btn-outline-primary btn-sm d-flex justify-content-between align-items-center"  href="{{ route('invoices.print',$invoice) }}" >
                                                    <span> طباعه الفاتوره</span>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>

                                            <div class="ml-3">
                                                <button class="modal-effect btn btn-outline-danger btn-sm d-flex justify-content-between align-items-center" data-effect="effect-scale" data-toggle="modal" data-target="#modaldelete{{ $invoice->id }}">
                                                    <span>حذف</span>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <div class="modal fade" id="modaldelete{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefault" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">حذف فاتوره</h6>
                                                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-danger "> هل انت متاكد من حذف هذا الفاتوره </div>

                                                <form method="post" action="{{ route('invoices.destroy', $invoice) }}">
                                                @csrf
                                                @method('delete')
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn ripple btn-danger" type="submit">حذف الفاتوره</button>
                                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row m-lg-5">
                            <div class="col-12 col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    {{ __('اظهر :start الي :end من اصل :total سجل', ['start' => $invoices->firstItem(), 'end' => $invoices->lastItem(), 'total' => $invoices->total()]) }}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                    {{ $invoices->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>

    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Add your JS script links here -->
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                paging: true, // Enable DataTables pagination
                searching: true, // Enable search
                info: true, // Show the information text
                // Add Bootstrap 4 compatibility
            });
        });

    </script>
@endsection

@section('js')
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/table-data.js')}}"></script>
    <script src="{{asset('assets/js/modal.js')}}"></script>
    <!-- Internal Treeview js -->
    <script src="{{asset('assets/plugins/treeview/treeview.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
