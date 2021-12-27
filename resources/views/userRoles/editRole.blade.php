@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">تعديل مجموعة مستخدمين</span>
            {{-- <span class="caption-helper">{{Translator::get('add_category_caption')}}</span> --}}
        </div>
        {{-- <div class="actions">
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-cloud-upload"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-wrench"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-trash"></i>
            </a>
        </div> --}}
    </div>
    <div class="portlet-body">
        <form action="{{route('employee.roles.update',$role->id)}}" method="POST">
            @csrf
            @method('put')
            <div class="form-body">
                <div class="form-group col-md-12">
                    <label class="col-md-2 control-label">اسم المجموعة</label>
                    <div class="col-md-11">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input readonly value="{{$role->name}}" type="text"  name="name" class="form-control" placeholder="اسم المجموعة">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label >اختر صلاحيات المجموعة</label>

                    <div class="mt-checkbox-inline">
                        @foreach($permissions as $permission)
                        <div class="col-md-4">
                            <label class="mt-checkbox">
                                <input id="permission_{{$permission->id}}" {{$role->hasPermissionTo($permission->id)?'checked':''}} name="permissions[]" value="{{$permission->id}}" type="checkbox">
                                {{$permission->name_ar}}
                                <span></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-6">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="" class="btn red"><i class="fa fa-close"></i>الغاء</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

@endsection
