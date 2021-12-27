@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        @if(!isset($item->id))
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">تقرير</span>
                <span class="caption-helper">الاوردرات</span>
            </div>
        @else
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">الاوردرات</span>
                <span class="caption-helper">الاوردرات</span>
            </div>
        @endif
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('reports.orders.getOrdersData') }}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                @if(isset($item->id))
                    @method('PUT')
                @endif
                {{ csrf_field() }}
                <div class="form-group">
                    @error('resturant_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">المطعم</label>
                    <div class="col-md-4">
                        <select name="resturant_id" required class="form-control select2" id="resturants">
                            @foreach ($resturants as $resturant)
                                <option value="{{$resturant->id}}">{{$resturant->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>بحث</button>
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
    $(document).ready(function()
    {
        $("#resturants").change(function()
        {
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            let resturantId = $("#resturants").val();
            $.get('{{route("resturants.ajax.getCategories")}}',
            {
                'resturant_id': resturantId,
            },function (data)
            {
                var categories = $("#categories");
                categories.html('');
                for(var i = 0; i<data.length;i++)
                {
                    let category = data[i];
                    let option = "<option value="+category.id+">"+category.display_name+"</option>"
                    categories.append(option);
                }
            });
        });
    });
</script>
@endsection
