@extends('layouts.adminPanel.admin')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">
                    @if ($resturant)
                        منتجات مطعم {{$resturant->display_name}}
                    @else
                    المنتجات
                    @endif
                    </span>
                </div>
                {{-- <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                            <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                        <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                            <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                    </div>
                </div> --}}
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                @can('add products')
                                <a
                                @if ($resturant)
                                href="{{route('resturants.items.create',$resturant->id)}}"

                                @else
                                href="{{route('items.create')}}"
                                @endif

                                id="sample_editable_1_new" class="btn sbold green">
                                    اضافة
                                    <i class="fa fa-plus"></i>
                                </a>
                                @endcan

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul id="actions" class="dropdown-menu pull-right">
                                    <li>
                                        <button class="">
                                            <i class="fa fa-print"></i> Print </button>
                                    </li>
                                    <li>
                                        <button class="">
                                            <i class="fa fa-file-pdf-o"></i> Save as PDF </button>
                                    </li>
                                    <li>
                                        <button class="">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="buttons">

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> الاسم بالعربية </th>
                            <th> الاسم بالانجيليزية </th>
                            <th> نوع المنتج </th>
                            <th> المطعم </th>
                            <th> {{Translator::get('price_before')}} </th>
                            <th> {{Translator::get('price_after')}} </th>
                            @can('view sizes')
                            <th> الاحجام </th>
                            @endcan
                            @can('view sizes')
                            <th>  مشاهدة الاحجام </th>
                            @endcan
                            @can('add sizes')
                            <th> اضافة حجم </th>
                            @endcan
                            @can('view sides')
                            <th> وحدات الاضافات </th>
                            @endcan
                            @can('view sides')
                            <th>  مشاهدة وحدات الاضافات </th>
                            @endcan
{{--                            @can('add sides')--}}
{{--                            <th>  الاضافات   </th>--}}
{{--                            @endcan--}}
{{--                            <th> الوصف بالعربية </th>--}}
{{--                            <th> الوصف بالانجليزية </th>--}}
                            @can('update products')
                            <th> تعديل </th>
                            @endcan
                            @can('delete products')
                            <th> حذف </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="odd gradeX">

                                <td> {{$item->name_ar}} </td>
                                <td> {{$item->name_en}} </td>
                                <td> {{$item->category->name_ar}} </td>
                                <td> {{$item->resturant->display_name}} </td>
                                <td> {{$item->price_before}} </td>
                                <td> {{$item->price_after}} </td>
                            @can('view sizes')
                                <td>
                                    <ul>
                                        @foreach ($item->sizes as $size)
                                            <li>
                                                {{$size->name_ar}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            @endcan
                            @can('view sizes')
                                <td>
                                    <a href="{{route('sizes.index',$item->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        الاحجام
                                    </a>
                                </td>
                            @endcan
                            @can('add sizes')
                                <td>
                                    <a href="{{route('sizes.create',$item->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        اضافة حجم
                                    </a>
                                </td>
                            @endcan
                            @can('view sides')
                                <td>
                                    <ul>
                                        @foreach ($item->sides as $side)
                                            <li>
                                                {{$side->name_ar}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            @endcan
                            @can('view sides')
                                <td>
                                    <a href="{{route('sides.index',$item->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        وحدات الاضافات
                                    </a>
                                </td>
                            @endcan
{{--                            @can('add sides')--}}
{{--                                @if($item->side_slots > 0 )--}}
{{--                                <td>--}}
{{--                                    <a href="{{route('sides.create',$item->id)}}" class="btn blue"><i class="fa fa-edit"></i>--}}
{{--                                        اضافة--}}
{{--                                    </a>--}}
{{--                                </td>--}}
{{--                                @else--}}
{{--                                <td> لايمكن الاضافه</td>--}}
{{--                                @endif--}}
{{--                            @endcan--}}
{{--                                <td> {{$item->description_ar}} </td>--}}
{{--                                <td> {{$item->description_en}} </td>--}}
                                @can('update products')
                                <td>
                                    <a href="{{route('items.edit',$item->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        تعديل
                                    </a>
                                </td>
                                @endcan
                                @can('delete products')
                                <td>
                                    <form action="{{route('items.destroy',$item->id)}}" method="POST">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button type="submit" class="btn red"><i class="fa fa-trash"></i>
                                        حذف
                                    </button>
                                    </form>
                                </td>
                                @endcan


                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
@section('javascript')
{{-- <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function()
    {
        var table = $("#sample_1");
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'print',
            'pdfHtml5'
            ]
        }).container().appendTo($('#buttons'));
    });
</script> --}}
@endsection
