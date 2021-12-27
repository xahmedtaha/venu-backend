@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                <i class="icon-bubble font-green-sharp"></i>
                    <span class="caption-subject bold uppercase">{{text::get('addnewgroup')}}</span>
                </div> 
            </div> 		 
            <div class="portlet-body form">
                <form  action="{{url('saveusersgroup')}}" method="post" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-body">
                        {{ csrf_field() }} 
                        <div class="form-group col-sm-12">
                            <label> {{text::get('groupname')}} </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text"  name="name" required="" class="form-control" placeholder="ادخل اسم المجموعه  ....."> </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <ul class="nav nav-tabs tabs-left">
                                @php  $r_num=1; @endphp
                                    @foreach($cats as $cat)                                                    
                                    <li @if( $r_num ===1 )  class="active" @endif >
                                        <a href="#{{$cat->section}}_11" data-toggle="tab" aria-expanded="@if( $r_num ===1 )true @else false @endif">
                                    {{$cat->section_ar}}
                                        </a>
                                    </li>                                             
                            @php $r_num++; @endphp  
                        @endforeach    

                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <div class="tab-content">
                                @php  $r_num=1; @endphp
                                    @foreach($cats as $cat)   

                                    <div class="tab-pane @if( $r_num ===1 ) active in @else fade @endif" id="{{$cat->section}}_11">
                                    
                                <div class="form-group"> 
                                    <div class="mt-checkbox-inline"> 
                                        @php  $r_num=1; 
                                        $rolls = App\UserRollsModel::where('section',$cat->section)->get();
                                        @endphp
                                        @foreach($rolls as $roll)                                                        
                                        <label class="mt-checkbox">                                 
                                            <input id="user_roll_{{$r_num}}" name="userroll[]" value="{{$roll->id}}" type="checkbox"> {{$roll->name}} 

                                            <span></span>
                                        </label> 
                                        @php $r_num++; @endphp  
                                        @endforeach   
                                    </div>
                                </div>


                                    </div>
                                @php $r_num++; @endphp  
                                @endforeach    

                                </div>
                            </div>
                        </div>
                    </div><!-- // end form body --> 

                    <div class="form-actions">        
                            <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green"> {{text::get('savedata')}} <li class="fa fa-save"></li></button>
                            <a href="{{url('/allusersgroup')}}" class="btn btn-circle green"> مشاهدة الكل <li class="fa fa-file"></li></a>
                            
                            <button type="reset" class="btn btn-circle dark"> مسح <li class="fa fa-trash"></li></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET--> 
    </div> 
</div> 
@endsection