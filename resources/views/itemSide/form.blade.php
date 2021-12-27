@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        @if(isset($side->id))
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">اضافات المنتج</span>
                <span class="caption-helper">اضافات المنتج</span>
            </div>
        @else
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">تعديل اضافات منتج</span>
                <span class="caption-helper">تعديل اضافات منتج</span>
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
        <form action="{{isset($side->id) ? route('sides.update',['item'=>$side->item_id,'side' => $side->id]) : route('sides.store',$item->id)}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                @if(isset($side->id))
                    @method('PUT')
                @endif
                {{ csrf_field() }}

                <div class="form-group col-md-6">
                    @error('name_ar')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_ar" value="{{$side->name_ar}}" required class="form-control" placeholder="الاسم بالعربية">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_en" value="{{$side->name_en}}" class="form-control" placeholder="الاسم بالانجيليزية">
                    </div>
                </div>

                <div class="form-group">
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">السعر</label>
                    <div class="col-md-4">
                        <input type="number" step=".01" value="{{$side->price}}" name="price" class="form-control" placeholder="السعر">
                    </div>
                </div>

                <div class="form-group">
                    @error('weight')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">عدد وحدات الاضافة</label>
                    <div class="col-md-4">
                        <input type="number" step=".01" value="{{$side->weight}}" name="weight" class="form-control" placeholder="عدد وحدات الاضافة">
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
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
