@extends('layouts.main')
@section('content')              
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">@if(isset($page_title)) {{$page_title}} @endif</span>
                                @if( UserRoll::check('add_users') === TRUE)
                                <a href="{{url('/adduser')}}" class="btn green-seagreen"> <li class="fa fa-plus-square"></li> إضافه جديد </a>
                                @endif                                             
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
                        <thead>
                            <tr> 
                                <th>اسم الموظف</th>  
                                <th>البريد الإلكتروني</th>   
                                <th>الجوال</th>      
                                <th>رقم الهويه </th>      
                                <th>الجنسيه</th>      
                                <th>الوظيفه</th>      
                                <th>الفئه </th>      
                                <th>مجموعه المستخدمين </th> 
                                <th>الفرع</th> 
                                <th>المخزن</th>  
                                <th>اسم المستخدم </th>      
                                <th>صوره المستخدم</th>      
                                <th>{{text::get('edit')}}</th>  
                                <th>{{text::get('delete')}}</th>  
                            </tr>
                        </thead>
                        <tbody> 
                        @if( count($users))
                            @foreach($users as $user )
                            <tr>
                                <td>{{$user->name}}</td> 
                                <td>{{$user->email}}</td> 
                                <td>{{$user->phone}}</td> 
                                <td>{{$user->id_number}}</td> 
                                <td>{{$user->nationality}}</td> 
                                <td>{{$user->job}}</td> 
                                <td>{{text::get($user->level)}}</td>        
                                <td>{{App\UsersgGroupModel::get_name($user->group_id)}}</td>  
                                <td>@if($user->branch){{$user->branch->name}}@endif</td>  
                                <td>@if($user->stock){{$user->stock->name}}@endif</td>  
                                <td>{{$user->name}}</td>       
                                <td>
                                @if($user->photo != NULL)    
                                <img src="{{url('/uploads/users')}}/{{$user->photo}}" style="width: 50px;height: 50px;border-radius: 5px;"/>
                                @endif
                                </td>        
                                <td>
                                        <a title="{{text::get('edit')}}" href="{{url('/users')}}/{{$user->id}}" class="btn btn-sm green-meadow"> {{text::get('edit')}} <i class="fa fa-edit"></i></a>
                                </td> 
                                <td>   
                                   <?php
                                    $user_num = App\User::where('level', 'Fulladmin')->count();
                                    ?>                                     
                                   @if($user->level ==='Fulladmin' && $user_num === 1 )
                                   @else
                                   @if(UserRoll::deleteUser($user->id))
                                   <a onclick="return delete_data({{$user->id}})" class="btn btn-sm red"> {{text::get('delete')}} <i class="fa fa-trash"></i></a> 
                                   @else
                                   لا يمكنك حذف هذا المستخدم
                                   @endif
                                   @endif 
                                </td>  
                            </tr>
                            @endforeach   
                        @endif                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
<script type="text/javascript">
    function delete_data($item_id) { 
     var itemID = $item_id;
    @if(config('sys.sounds') ==='yes')
    var audio = new Audio('{{asset('public/mp3/erorr.mp3')}}'); audio.play(); 
    @endif
    swal({
        title: "{{text::get('confirmdelete')}}",
        text: "{{text::get('confirmdelete_ms')}}", 
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true, 
        confirmButtonText: "{{text::get('confirmdelete_btn')}}",
        cancelButtonText:  "{{text::get('cancel')}}",
        confirmButtonClass:'btn btn-success',
        cancelButtonClass: 'btn btn-danger',       
    }, function() {
        setTimeout(function() {
            $.post("{{url('/deleteusers')}}", {
                   _token: '{{ csrf_token() }}',
                    rowid: itemID
                },
                function(data, status) {
                    swal({
                           title: "{{text::get('Deleted')}}",
                           text: "{{text::get('Deleted_suss')}}", 
                           type: "success"  
                        },
                        function() {
                            location.reload();
                        }
                    );
                }
            );
        }, 10);
    }); 
      }     
</script>
@endsection