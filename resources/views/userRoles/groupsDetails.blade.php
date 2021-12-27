@extends('layouts.adminPanel.admin')
@section('content')
            
@if(!$errors->isEmpty())
	<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
           <strong></strong> 
    </div>
@endif 
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                <i class="icon-bubble font-green-sharp"></i>
                    <span class="caption-subject bold uppercase">صلاحيات مجموعات المستخدمين</span>
                </div> 
            </div> 		 
            <div class="portlet-body form">
                <form  action="{{url('updateusersgroup')}}" method="post" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-body">
                        {{ csrf_field() }}
                        <div class="col-sm-12"> 

                            <h3 align="center"> الصلاحيات الخاصه بالمجموعه</h3>
                        </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <ul class="nav nav-tabs tabs-left">
                        @php  $r_num=1; @endphp
                            @foreach($roles as $role)                                                    
                            <li @if( $r_num ===1 )  class="active" @endif >
                                <a href="#role_{{$role->id}}" data-toggle="tab" aria-expanded="@if( $r_num ===1 )true @else false @endif">
                                    {{$role->name}}
                                </a>
                                <a class="btn btn-green" href="{{route('employee.roles.edit',$role->id)}}">
                                    <i class="fa fa-edit"></i> 
                                    تعديل
                                </a>
                            </li>                                             
                    @php $r_num++; @endphp  
                @endforeach    
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="tab-content">
                        @php  $r_num=1; @endphp
                            @foreach($roles as $role)   
                            <div class="tab-pane @if( $r_num ===1 ) active in @else fade @endif" id="role_{{$role->id}}">                                                  
                        <div class="form-group">

                            <div class="mt-checkbox-inline"> 
                                @php  $r_num=1; 
                                @endphp
                                @foreach($permissions as $permission)   
                                <div class="col-md-4">
                                    <label class="mt-checkbox">                                 
                                        <input disabled id="user_roll_{{$r_num}}" name="permissions[]" value="{{$permission->id}}" type="checkbox" @if($role->hasPermissionTo($permission->id)) checked="" @endif > 
                                        {{$permission->name_ar}} 
                                        <span></span>
                                    </label> 
                                </div>     
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

                        <?php /* <div class="form-group">
                            <label>{{trans::cmslang('user_choose_rolls')}}</label>

                            <div class="mt-checkbox-inline">
                                @if( count($cats))
                                @php  $r_num=1; @endphp
                                @foreach($cats as $cat)                                                        
                                <label class="mt-checkbox">                                 
                                    <input id="user_roll_{{$r_num}}" name="userroll[]" value="{{$roll->id}}" type="checkbox"> {{$roll->name}}</h3>

                                    <span></span>
                                </label> 
                                @php $r_num++; @endphp  
                        @endforeach   
                    @endif
                            </div>
                        </div>                                                                                        
                    </div> */ ?>                                        
                    </div><!-- // end form body --> 

            <div class="form-actions">        
                    <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-circle green"> حفظ <li class="fa fa-save"></li></button>
                </div>
            </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET--> 
    </div> 
</div> 
@endsection