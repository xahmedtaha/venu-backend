@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">تعديل بيانات الموظف</span>
            <span class="caption-helper">{{Translator::get('add_category_caption')}}</span>
        </div>

    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="{{route('employee.update',$employee->id)}}" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-2 control-label">ادمن</label>
                    <div class="col-md-8">
                        @error('is_admin')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <input type="number" required name="" class="form-control" placeholder="{{Translator::get('is_admin')}}"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{$employee->level=="SuperAdmin"?'checked':''}} id="customRadioInline1" value="1" name="is_admin" class="custom-control-input admin_radio">

                            <label class="custom-control-label"  for="customRadioInline1">نعم</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{$employee->level!="SuperAdmin"?'checked':''}} id="customRadioInline2" value="0" name="is_admin" class="custom-control-input admin_radio">

                            <label class="custom-control-label" for="customRadioInline2">لا</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="roles_div" style="{{$employee->level=="SuperAdmin"?"display:none":""}}">
                    @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">مجموعة المستخدمين</label>
                    <div class="col-md-4">
                        <select name="role_id" required class="form-control select2" id="roles">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" name="resturant" required class="form-control" placeholder="المطعم"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group" id="all_resturants_div">
                    <label class="col-md-2 control-label">المطاعم</label>
                    <div class="col-md-8">
                        @error('all_resturants')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <input type="number" required name="" class="form-control" placeholder="{{Translator::get('is_admin')}}"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" value="1" name="all_resturants" class="custom-control-input all_resturants_radio">

                            <label class="custom-control-label"  for="customRadioInline1">الكل</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" checked id="customRadioInline2" value="0" name="all_resturants" class="custom-control-input all_resturants_radio">

                            <label class="custom-control-label" for="customRadioInline2">مطاعم محددة</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="resturants_div">
                    @error('resturant')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">حدد المطاعم</label>
                    <div class="col-md-4">
                        <select name="resturants[]" multiple required class="form-control select2" id="resturants">
                            @foreach ($resturants as $resturant)
                                <option value="{{$resturant->id}}">{{$resturant->display_name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"> المطاعم التى يمكن للمستخدم التعامل معها اذا كان فى مجموعة مستخدمين لها صلاحية للمطاعم </span>
                    </div>
                </div>

                <div class="form-group">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('name')}}</label>
                    <div class="col-md-4">
                        <input type="text" name="name" required class="form-control" placeholder="{{Translator::get('name')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('email')}}</label>
                    <div class="col-md-4">
                        <input type="email" name="email" class="form-control" placeholder="{{Translator::get('email')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('password')}}</label>
                    <div class="col-md-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{Translator::get('password')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('confirm_password')}}</label>
                    <div class="col-md-4">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{Translator::get('confirm_password')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="button" onclick="validatePassword()" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="{{route('resturantOwners.index')}}" class="btn red"><i class="fa fa-close"></i>الغاء</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection
@section('javascript')
<script>
function validatePassword()
{
    if($("#password").val()==$("#confirm_password").val())
    {
        $("form").submit();
    }
    else
    {
        alert("{{Translator::get('confirm_password')}}");
    }
}
$(document).ready(function(){
    $('.admin_radio').click(function ()
    {
        let admin_flag = $("input[name='is_admin']");
        console.log(admin_flag);

        if(admin_flag.prop('checked')==true)
        {
            $('#resturants').attr('disabled','true');
            $('#resturants').hide();
            $('#resturants_div').hide();

            $('#roles').attr('disabled','true');
            $('#roles').hide();
            $('#roles_div').hide();

        }
        else
        {
            $('#resturants').removeAttr('disabled');
            $('#resturants').show();
            $('#resturants_div').show();

            $('#roles').removeAttr('disabled');
            $('#roles').show();
            $('#roles_div').show();
        }
    });
    $('.all_resturants_radio').click(function ()
    {
        let all_resturants_flag = $("input[name='all_resturants']");

        if(all_resturants_flag.prop('checked')==true)
        {
            $('#resturants').attr('disabled','true');
            $('#resturants').hide();
            $('#resturants_div').hide();
        }
        else
        {
            $('#resturants').removeAttr('disabled');
            $('#resturants').show();
            $('#resturants_div').show();
        }
    });
});
</script>
@endsection
