@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة موظف</span>
            <span class="caption-helper">{{Translator::get('add_category_caption')}}</span>
        </div>

    </div>
    <div class="portlet-body form">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- BEGIN FORM-->
        <form action="{{isset($waiter->id)?route('waiter.update',$waiter->id):route('waiter.store')}}" class="form-horizontal" method="POST">
            <div class="form-body">
                @isset($waiter->id)
                    @method('PUT')
                @endisset
                {{ csrf_field() }}

                <div class="form-group" id="resturants_div" >
                    @error('resturant_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">حدد المطعم</label>
                    <div class="col-md-4">
                    <select name="resturant_id"  required class="form-control select2" id="resturants" >
                            @foreach ($resturants as $resturant)
                                <option {{$waiter->resturant_id == $resturant->id?'selected':''}} value="{{$resturant->id}}">
                                    {{$resturant->display_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" id="resturants_div" >
                    @error('branch_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">حدد الفرع</label>
                    <div class="col-md-4">
                        <select name="branch_id"  required class="form-control select2" id="branches">
                            @foreach ($branches as $branch)
                            <option {{$waiter->branch_id == $branch->id?'selected':''}} value="{{$branch->id}}">
                                {{$branch->name_ar}}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم</label>
                    <div class="col-md-4">
                    <input value="{{$waiter->name}}" type="text" name="name" required class="form-control" placeholder="الاسم">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">البريد الالكترونى</label>
                    <div class="col-md-4">
                        <input value="{{$waiter->email}}" type="email" name="email" class="form-control" placeholder="البريد الالكترونى">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">كلمة المرور</label>
                    <div class="col-md-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="كلمة المرور">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">تاكيد كلمة المرور</label>
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
                        <a href="{{route('waiter.index')}}" class="btn red"><i class="fa fa-close"></i>الغاء</a>
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
        alert("تاكيد كلمه المرور");
    }
}
</script>
<script>
var url = "{{url('/')}}";
$('#resturants').on('change',function(){
    $('#branches').empty();
    var id =$('#resturants').val();
    $('#branches').html('<option selected="selected" value="">اختر المطعم اولااا</option>');
    var url = "{{url('/get_branchs')}}" +'/'+ id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success:function(data){
            console.log(data);
            $('#branches').html('<option selected="selected" value="">اختر المطعم </option>');
            $.each(data, function(id,name_ar){
                $('#branches').append('<option selected="selected" value="'+name_ar+'"> '+id+'</option>')
            });
        }
    });
});
</script>
@endsection
