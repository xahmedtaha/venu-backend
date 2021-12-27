@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة منتج</span>
            <span class="caption-helper">{{Translator::get('add_product')}}</span>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('subProducts.update',$subProduct->id)}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
                @method('PUT')
                <div class="form-group">
                    @error('resturant_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">المطعم</label>
                    <div class="col-md-4">
                        <input name="" type="text" class="form-control" readonly value="{{$subProduct->product->resturant->display_name}}">

                        {{-- <input type="text" name="resturant" required class="form-control" placeholder="المطعم"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('product_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">المنتج</label>
                    <div class="col-md-4">
                        <input name="" type="text" class="form-control" readonly value="{{$subProduct->product->display_name}}">
                        {{-- <input type="text" name="resturant" required class="form-control" placeholder="المطعم"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('name_ar')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم بالعربية</label>
                    <div class="col-md-4">
                        <input value="{{$subProduct->name_ar}}" type="text" name="name_ar" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-4">
                        <input type="text" value="{{$subProduct->name_en}}" name="name_en" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('price_before')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">السعر</label>
                    <div class="col-md-4">
                        <input type="number" value="{{$subProduct->price_before}}" step=".01" name="price_before" class="form-control" placeholder="السعر">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('description_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالعربية</label>
                    <div class="col-md-4">
                        <textarea name="description_ar"  class="form-control" id="" cols="30" rows="10">{{$subProduct->description_ar}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('description_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالانجليزية</label>
                    <div class="col-md-4">
                        <textarea name="description_en"  class="form-control" id="" cols="30" rows="10">{{$subProduct->description_en}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"> {{Translator::get('product_images')}} </label>
                    <div class="col-md-6">
                        @error('images')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="file" name="images[]" multiple id="customFile">
                    </div>
                </div>



            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        {{-- <a href="{{route('products.index')}}" class="btn red"><i class="fa fa-close"></i>الغاء</a> --}}
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

</script>
@endsection
