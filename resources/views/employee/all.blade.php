@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">الموظفين</span>
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
                            @can('add employees')
                            <div class="btn-group">
                                @can('add employees')
                                <a href="{{route('employee.create')}}" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة
                                    <i class="fa fa-plus"></i>
                                </a>
                                @endcan

                            </div>
                            @endcan
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
                            <th> الاسم </th>
                            <th> مجموعة المستخدمين </th>
                            <th> الايميل</th>
                            @can('update employees')
                            <th> تعديل </th>
                            @endcan
                            @can('delete employees')
                            <th> حذف </th>
                            @endcan

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="odd gradeX">

                                <td> {{$employee->name}} </td>
                                <td>
                                @if ($employee->level!="SuperAdmin")
                                    {{$employee->roles->first()->name}}
                                @else
                                    ادمن
                                @endif
                                </td>
                                <td> {{$employee->email}} </td>
                                @can('update employees')
                                
                                <td>
                                    @if($employee->level!="SuperAdmin"||$employee->id==Auth::user()->id)
                                    <a href="{{route('employee.edit',$employee->id)}}" class="btn blue"><i class="fa fa-edit"></i>
                                        تعديل
                                    </a>
                                    @endif
                                </td>
                                
                                @endcan
                                @can('delete employees')
                                
                                <td>
                                    @if($employee->level!="SuperAdmin"||$employee->id==Auth::user()->id)
                                    <form action="{{route('employee.destroy',$employee->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button type="submit" class="btn red"><i class="fa fa-trash"></i>
                                            حذف
                                        </button>
                                    </form>
                                    @endif
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
