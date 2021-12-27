@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة حجم</span>
            <span class="caption-helper">{{Translator::get('add_product')}}</span>
        </div>
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
        <form action="{{isset($size->id)?route('sizes.update',['item'=>$item->id,'size' => $size->id]):route('sizes.store',$item->id)}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                @isset($size->id)
                    @method('PUT')
                @endisset
                {{ csrf_field() }}
{{--                <div class="form-group">--}}
{{--                    @error('resturant_id')--}}
{{--                    <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                    <label class="col-md-2 control-label">المطعم</label>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <input type="text" class="form-control" name="" disabled readonly value="{{$product->resturant->display_name}}">--}}
{{--                        <input type="hidden" name="resturant_id" value="{{$product->resturant->id}}">--}}
{{--                        --}}{{-- <input type="text" name="resturant" required class="form-control" placeholder="المطعم"> --}}
{{--                        --}}{{-- <span class="help-block"> A block of help text. </span> --}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="form-group">
                    @error('item_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">المنتج</label>
                    <div class="col-md-4">
                        <input name="item_id" type="hidden" value="{{$item->id}}">
                        <input name="" type="text" class="form-control" readonly value="{{$item->name}}">
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
                        <input type="text" value="{{$size->name_ar}}" name="name_ar" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-4">
                        <input type="text" value="{{$size->name_en}}" name="name_en" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('price_before')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">السعر</label>
                    <div class="col-md-4">
                        <input type="number" value="{{$size->price_before}}" step=".01" name="price_before" class="form-control" placeholder="السعر">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('description_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالعربية</label>
                    <div class="col-md-4">
                        <textarea name="description_ar" class="form-control" id="" cols="30" rows="10">{{$size->description_ar}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('description_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالانجليزية</label>
                    <div class="col-md-4">
                        <textarea name="description_en" class="form-control" id="" cols="30" rows="10">{{$size->description_en}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

{{--                <div class="form-group">--}}
{{--                    <label class="col-md-2 control-label"> {{Translator::get('product_images')}} </label>--}}
{{--                    <div class="col-md-6">--}}
{{--                        @error('images')--}}
{{--                            <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                        <input type="file" required name="images[]" multiple id="customFile">--}}
{{--                    </div>--}}
{{--                </div>--}}
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
    // $(document).ready(function()
    // {

    //     $("#resturants").change(function()
    //     {
    //         $.ajaxSetup({
    //         headers: {
    //                 'X-CSRF-TOKEN': '{{csrf_token()}}'
    //             }
    //         });
    //         let resturantId = $("#resturants").val();
    //         $.get('{{route("resturants.ajax.getCategories")}}',
    //         {
    //             'resturant_id': resturantId,
    //         },function (data)
    //         {
    //             console.log(data);

    //         });
    //     });
    // });
</script>
@endsection
