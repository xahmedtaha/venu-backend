@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">المطاعم</span>
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
                                @can('add resturants')
                                <a href="{{route('resturants.create')}}" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة مطعم
                                    <i class="fa fa-plus"></i>
                                </a>
                                @endcan

                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-print"></i> Print </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <table class="table table-striped table-bordered table-header-fixed table-hover order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> الاسم بالعربية </th>
                            <th> الاسم بالانجليزية </th>
                            @can('view branches')
                            <th> الفروع </th>
                            @endcan
                            @can('view lists')
                            <th> الليستات </th>
                            @endcan
                            @can('view products')
                            <th> المنتجات </th>
                            @endcan
                            @can('view product categories')
                            <th> انواع المنتجات  </th>
                            @endcan
                            <th> وقت العمل من </th>
                            <th> وقت العمل الى </th>
                            <th> ضريبة قيمة مضافة </th>
                            <th> % قيمة الضريبة </th>
                            <th> رقم الهاتف </th>
                            @can('update resturants')
                            <th> تعديل </th>
                            @endcan
                            @can('delete resturants')
                            <th> مسح </th>
                            @endcan

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resturants as $resturant)
                            <tr class="">

                                <td> {{$resturant->name_ar}} </td>
                                <td> {{$resturant->name_en}} </td>
                                @can('view branches')   
                                <td>
                                    <a href="{{route('resturants.branches.index',$resturant->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        الفروع
                                    </a>
                                </td>
                                @endcan
                                @can('view lists')  
                                <td>
                                    <a href="{{route('lists.index',$resturant->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        الليستات
                                    </a>
                                </td>
                                @endcan
                                @can('view products')   
                                <td>
                                    <a href="{{route('resturants.items.index',$resturant->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        المنتجات
                                    </a>
                                </td>
                                @endcan
                                @can('view product categories') 
                                <td>
                                    <a href="{{route('itemCategories.index',$resturant->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        انواع المنتجات
                                    </a>
                                </td>
                                @endcan                                 
                                <td> {{$resturant->open_time}} </td>
                                <td> {{$resturant->close_time}} </td>
                                <td>
                                    @if ($resturant->vat_on_total)
                                        <span class='label lable-sm label-success'>نعم </span>
                                    @else
                                        <span class='label lable-sm label-danger'>لا </span>
                                    @endif
                                </td>
                                <td> {{$resturant->vat_value}} </td>
                                <td> {{$resturant->phone_number}} </td>
                                @can('update resturants')
                                <td>
                                    <a href="{{route('resturants.edit',$resturant->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        تعديل
                                    </a>
                                </td>
                                @endcan
                                @can('delete resturants')
                                <td>
                                    <form action="{{route('resturants.destroy',$resturant->id)}}" method="POST">
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
<script>

</script>

@endsection
