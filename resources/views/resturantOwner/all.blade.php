@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{Translator::get('resturant_owners')}}</span>
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
                                @can('add resturant owners')

                                <a href="{{route('resturantOwners.create')}}" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة
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
                <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> الاسم بالعربية </th>
                            <th> الاسم بالانجيليزية </th>
                            <th> المطعم </th>
                            <th> {{Translator::get('email')}} </th>
                            @can('update resturant owners')
                            <th> تعديل </th>
                            @endcan
                            @can('delete resturant owners')
                            <th> حذف </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resturantOwners as $resturantOwner)
                            <tr class="odd gradeX">

                                <td> {{$resturantOwner->name_ar}} </td>
                                <td> {{$resturantOwner->name_en}} </td>
                                <td> {{$resturantOwner->resturant->display_name}} </td>
                                <td> {{$resturantOwner->email}} </td>
                                @can('update resturant owners')
                                <td>
                                    <a href="{{route('resturantOwners.edit',$resturantOwner->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        تعديل
                                    </a>
                                </td>
                                @endcan
                                @can('delete resturant owners')
                                <td>
                                    <form action="{{route('resturantOwners.destroy',$resturantOwner->id)}}" method="POST">
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
