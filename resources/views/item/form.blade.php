@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        @if(!isset($item->id))
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">اضافة منتج</span>
                <span class="caption-helper">اضافة منتج</span>
            </div>
        @else
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">تعديل منتج</span>
                <span class="caption-helper">تعديل منتج</span>
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
        <form action="{{isset($item->id) ? route('items.update',$item->id) : route('items.store')}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
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
                        @if ($selectedResturant)
                            <select readonly="" name="resturant_id" required class="form-control" id="resturants">
                                <option value="{{$selectedResturant->id}}" selected>{{$selectedResturant->display_name}}</option>
                            </select>
                        @else
                        <select name="resturant_id" required class="form-control select2" id="resturants">
                            @foreach ($resturants as $resturant)
                                <option value="{{$resturant->id}}">{{$resturant->display_name}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    @error('resturant_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">نوع المنتج</label>
                    <div class="col-md-4">
                        <select name="category_id" required class="form-control select2" id="categories">
                            @if ($selectedResturant)
                                @foreach ($selectedResturant->itemCategories as $category)
                                    <option {{$item->category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">
                                        {{$category->name_ar}}
                                    </option>
                                @endforeach
                            @else
                                @foreach($resturants->first()->itemCategories as $category)
                                    <option {{$item->category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">
                                        {{$category->name_ar}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @if($selectedResturant)
                    <div class="col-md-2">
                            <a class="btn btn-primary" href="{{route('itemCategories.create',$selectedResturant->id)}}"><i class="fa fa-plus"></i>
                            اضافة نوع منتج
                        </a>
                    </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_ar" value="{{old('name_ar',$item->name_ar)}}"  class="form-control" placeholder="الاسم بالعربية">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_en" value="{{old('name_en', $item->name_en)}}" class="form-control" placeholder="الاسم بالانجيليزية">
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الوصف بالعربية</label>
                    <div class="col-md-8">
                        <textarea name="description_ar" class="form-control" id="" cols="30" rows="10">{{old('description_ar',$item->description_ar)}}</textarea>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الوصف بالانجليزية</label>
                    <div class="col-md-8">
                        <textarea name="description_en" class="form-control" id="" cols="30" rows="10">{{old('description_en',$item->description_en)}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"> صور </label>
                    <div class="col-md-6">

                        <input type="file" {{!isset($item->id)?'required':''}} name="images[]" multiple id="customFile">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">السعر</label>
                    <div class="col-md-4">
                        <input type="number" step=".01" value="{{old('price_after',$item->price_after)}}" name="price_before" class="form-control" placeholder="السعر">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">عدد وحدات الاضافة</label>
                    <div class="col-md-4">
                        <input type="number" step="1" value="{{old('side_slots',$item->side_slots)}}" name="side_slots" class="form-control" placeholder="عدد وحدات الاضافة">
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="{{route('items.index')}}" class="btn red"><i class="fa fa-close"></i>الغاء</a>
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
