@extends('layouts.master')
@section('css')


    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title','الاقسام')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الاقسام</span>
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
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <a class="modal-effect btn btn-outline-success btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">اضافه منتج</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <button class="modal-effect btn btn-outline-primary btn-block d-flex justify-content-between align-items-center" data-effect="effect-scale" data-toggle="modal" data-target="#modaledite{{ $product->id }}">
                                                    <span>تعديل</span>
                                                    <i class="fas fa-edit ml-2"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="modal-effect btn btn-outline-danger btn-block d-flex justify-content-between align-items-center" data-effect="effect-scale" data-toggle="modal" data-target="#modaldelete{{ $product->id }}">
                                                    <span>حذف</span>
                                                    <i class="fas fa-trash-alt ml-2"></i>
                                                </button>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <div class="modal fade" id="modaledite{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefault" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">تعديل منتج</h6>
                                                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('products.update', $product->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nameField{{ $product->id }}">اسم المنتج</label>
                                                        <input type="text" class="form-control" value="{{ $product->name }}" name="name" id="nameField{{ $product->id }}" placeholder="اسم المنتج">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descriptionField{{ $product->id }}">وصف المنتج/ملاحظات</label>
                                                        <textarea class="form-control" name="description" id="descriptionField{{ $product->id }}" rows="3" placeholder="اضف وصف للمنتج">{{ $product->description }}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn ripple btn-success" type="submit">تعديل المنتج</button>
                                                <button class="btn ripple btn-danger" data-dismiss="modal" type="button">اغلاق</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modaldelete{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefault" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">حذف المنتج</h6>
                                                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-danger "> هل انت متاكد من حذف هذا المنتج </div>

                                                <form method="post" action="{{ route('products.destroy', $product->id) }}">
                                                @csrf
                                                @method('delete')
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn ripple btn-danger" type="submit">حذف المنتج</button>
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
                                    {{ __('اظهر :start الي :end من اصل :total سجل', ['start' => $products->firstItem(), 'end' => $products->lastItem(), 'total' => $products->total()]) }}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('products.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nameField">اسم المنتج</label>
                            <input type="text" class="form-control" name="name" id="nameField" placeholder="اسم المنتج">
                        </div>
                        <div class="form-group">
                            <label for="descriptionField">وصف المنتج/ملاحظات</label>
                            <textarea class="form-control" name="description" id="descriptionField" rows="3" placeholder="اضف وصف للمنتج"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">حفظ المنتج</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                        </div>
                    </form>

                </div>
            </div>


        </div>




        <!-- End Basic modal -->

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
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
