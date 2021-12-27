@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        @if(!isset($list->id))
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">ليستات {{$resturant->name}}  </span>
                <span class="caption-helper">ليستات {{$resturant->name}}  </span>
            </div>
        @else
            <div class="caption">
                <i class="icon-equalizer font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">تعديل ليستات {{$resturant->name}}  </span>
                <span class="caption-helper">تعديل ليستات {{$resturant->name}}  </span>
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
        <form action="{{isset($list->id) ? route('lists.update',['resturant'=>$list->resturant_id,'list' => $list->id]) : route('lists.store',$resturant->id)}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                @if(isset($list->id))
                    @method('PUT')
                @endif
                {{ csrf_field() }}

                <div class="form-group col-md-6">
                    @error('name_ar')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_ar" value="{{$list->name_ar}}" required class="form-control" placeholder="الاسم بالعربية">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-8">
                        <input type="text" name="name_en" value="{{$list->name_en}}" class="form-control" placeholder="الاسم بالانجيليزية">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label"> المنتجات</label>
                    <div class="col-md-8">
                        <select name="items[]" id="items" multiple>
                            @foreach ($items as $item)
                            <option  value="{{$item->id}}">{{$item->name_ar}}</option>   
                            @endforeach
                        </select>
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

