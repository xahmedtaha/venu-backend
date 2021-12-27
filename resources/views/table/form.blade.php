@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة طاولة</span>
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
    <div class="portlet-body form">
        <!-- BEGIN FORM-->

        <form action="{{isset($table->id) ? route('branches.tables.update',['branch'=>$branch->id,'table'=>$table->id]) : route('branches.tables.store',['branch'=>$branch->id])}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                 {{csrf_field() }}
                @isset($table->id)
                    @method('PUT')
                @endisset
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">رقم الطاولة</label>
                    <div class="col-md-8">
                        @error('number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="number" min="1" value="{{$table->number}}" required class="form-control" placeholder="1">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                @if(auth()->user()->level == 'SuperAdmin')
                <div class="mt-checkbox-inline">
                    <div class="col-md-4">
                        <label class="mt-checkbox" for="test_mode">
                            <input id="test_mode" type="checkbox" name="test_mode" value="true">
                            Test Mode
                            <span></span>
                        </label>
                    </div>
                    <div class="col-md-2">
                        @error('test_mode')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                @endif
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-6">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <button type="reset" class="btn red"><i class="fa fa-close"></i>الغاء</button>
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
$(document).ready(function ()
{
    // $('.vat_radio').click(function ()
    // {
    //     let vat_flag = $("input[name='vat_on_total']");
    //     console.log(vat_flag);

    //     if(vat_flag.prop('checked')==false)
    //     {
    //         $('#vat_value').attr('disabled','true');
    //         $('#vat_value').hide();
    //         $('#vat_value_div').hide();

    //     }
    //     else
    //     {
    //         $('#vat_value').removeAttr('disabled');
    //         $('#vat_value').show();
    //         $('#vat_value_div').show();
    //     }
    // });
});
</script>
@endsection
