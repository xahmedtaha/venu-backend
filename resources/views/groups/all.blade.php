@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">مجموعات المستخدمين</span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                @can('add roles')
                                <a href="{{route('employee.roles.create')}}" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة
                                    <i class="fa fa-plus"></i>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-header-fixed" >
                    <thead>
                        <tr>
                            <th> اسم المجموعة </th>
                            <th> الصلاحيات </th>
                            @can('update roles')
                            <th> تعديل </th>
                            @endcan
                            @can('delete roles')
                            <th> حذف </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role )
                        <tr>
                            <td>{{$role->name}}</td>
                            <td>
                                <ul>
                                @foreach ($role->permissions as $permission)
                                    <li>
                                        {{$permission->name_ar}}
                                    </li>
                                @endforeach
                                </ul>
                            </td>
                            <td>
                                @can('update roles')
                                <a title="تعديل" href="{{route('employee.roles.edit',$role->id)}}" class="btn btn-sm green-meadow">
                                    تعديل <i class="fa fa-edit"></i>
                                </a>
                                @endcan
                            </td>
                            <td>
                                @can('delete roles')
                                <form id="delete_form_{{$role->id}}" action="{{route('employee.roles.destroy',$role->id)}}" method="POST">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button type="button" id="{{$role->id}}" class="delete-button btn red"><i class="fa fa-trash"></i>
                                        حذف
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

