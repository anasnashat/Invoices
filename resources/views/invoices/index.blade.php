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

                <div class="col-sm-6 col-md-4 col-xl-4 d-flex align-items-start justify-content-between mb-3">
                    <a class="btn btn-info" href="{{ route('invoices.create') }}">
                        <span class="ml-3">اضافه فاتوره</span> <i class="fas fa-plus-circle mr-3"></i>
                    </a>
                    <a class="btn btn-success" href="{{ route('invoices.export') }}">
                        <span class="ml-3">تصدير الي اكسيل</span> <i class="fas fa-file-excel mr-3"></i>
                    </a>
                </div>
                <!-- Your table should come right after this div -->


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

                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                العمليات
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  d-flex justify-content-between align-items-center" href="{{ route('invoices.edit', $invoice) }}">
                                                    <span>تعديل</span>
                                                    <i class="fas fa-edit" style="color: blue"></i>
                                                </a>
                                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('payment.create', $invoice) }}">
                                                    <span>دفع الفاتورة</span>
                                                    <i class="fas fa-money-bill-wave bx-font-color " style="color: green" ></i>
                                                </a>
                                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('invoices.print', $invoice) }}">
                                                    <span>طباعة الفاتورة</span>
                                                    <i class="fas fa-print" style="color: grey"></i>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <button class="dropdown-item btn-delete d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#modaldelete{{ $invoice->id }}">
                                                    <span>حذف</span>
                                                    <i class="fas fa-trash-alt" style="color: red"></i>
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
