@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">ترتيب اولوية ظهور المطاعم فى كل المطاعم</span>
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
                                    <button id="submit" type="button" class="btn btn-submit">حفظ</button>
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
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered table-header-fixed table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> الاسم بالعربية </th>
                                    <th> الاسم بالانجيليزية </th>
                                    <th> المدينة </th>

                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach ($resturants as $resturant)
                                    <tr id="{{$resturant->id}}" class="">
                                        <td><i class="fa fa-bars" style="cursor: grab"></i></td>
                                        <td> {{$resturant->name_ar}} </td>
                                        <td> {{$resturant->name_en}} </td>

                                        <td> {{$resturant->Place->display_name}} </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
@section('javascript')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
    $( "#sortable" ).sortable();

    $( "#sortable" ).disableSelection();
  } );

$(document).ready(function(){
    $("#submit").click(function (param)
    {
        var arr = $( "#sortable" ).sortable("toArray");
        $.post("{{route('resturants.sortAll.store')}}",{
            _token : "{{csrf_token()}}",
            sortingArr : arr
        },function (data)
        {
            if(data=="success")
                alert("تم الحفظ بنجاح");
        });

    });
});
</script>

@endsection
