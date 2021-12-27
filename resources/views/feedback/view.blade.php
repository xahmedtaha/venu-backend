@extends('layouts.adminPanel.admin')
<style>
 /* Chat containers */
 .container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

/* Darker chat container */
.darker {
  color: white;
  background-color: #337ab7;
}

/* Clear floats */
.container::after {
  content: "";
  clear: both;
  display: table;
}

/* Style images */
.container label {
  float: left;
  max-width: 150px;
  width: 100%;
  font-weight: bold;
  margin-right: 20px;
  border-radius: 50%;
  border-width: 1px;
  border-color: white;

}

/* Style the right image */
.container label.left {
  float: left;
  margin-left: 20px;
  margin-right:0;
}

/* Style time text */
.time-right {
  float: right;
}

/* Style time text */
.time-left {
  float: left;
} 
</style>
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">
                    رسائل العملاء
                    </span>
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
                <!--<div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a 
                                id="sample_editable_1_new" class="btn sbold green"> 
                                    
                                    <i class="fa fa-plus"></i>
                                </a>
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
                </div>!-->
                @foreach ($feedback->messages as $message)
                    <div class="row">
                    @if ($message->type == \App\Models\UserFeedbackMessage::TYPE_USER)
                        <div class="container darker col-md-12">
                            <label>المستخدم : {{$feedback->user->name}}</label>
                            <p> {{$message->message}} </p>
                            <span class="time-right"> {{$message->created_at->format('Y-m-d H:i:s a')}} </span>
                        </div>        
                    @else
                        <div class="container col-md-12">
                            
                            <p> {{$message->message}} </p>
                            <span class="time-right"> {{$message->created_at->format('Y-m-d H:i:s a')}} </span>
                        </div>
                    @endif
                    </div>
                @endforeach
                

                <div class="row">

                    <form action="{{route('feedbacks.store')}}" class="form-horizontal" method="POST">
                        <div class="form-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="feedback_id" value="{{$feedback->id}}">
                            <div class="form-group">
                                @error('message')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label class="col-md-1 control-label">الرسالة</label>
                                <div class="col-md-8">
                                    <textarea name="message" class="form-control" id="" cols="80" rows="10">
                                    </textarea>
                                    {{-- <span class="help-block"> A block of help text. </span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-4">
                                    <button type="submit" class="btn green"><i class="fa fa-save"></i>ارسال</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                
                
                

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection