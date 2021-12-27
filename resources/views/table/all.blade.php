@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">طاولات فرع {{$branch->name_ar}}</span>
                    <span class="caption-subject bold uppercase">مطعم {{$branch->resturant->name_ar}}</span>
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
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                @can('add resturants')
                                <a href="{{route('branches.tables.create',$branch->id)}}" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة طاولة
                                    <i class="fa fa-plus"></i>
                                </a>
                                @endcan

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
                </div>
                <table class="table table-striped table-bordered table-header-fixed table-hover order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> الرقم </th>
                            <th> الحالة </th>
                            @can('update resturants')
                            <th> تعديل </th>
                            <th> QR Code </th>
                            @endcan
                            @can('delete resturants')
                            <th> مسح </th>
                            @endcan

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr class="">

                                <td> {{$table->number}} {{$table->hash == 'c4ca4238a0b923820dcc509a6f75849b' ? '(Test Mode)' : ''}} </td>
                                <td> {{$table->state ? 'مشغولة' : 'متاحة'}} </td>
                                @can('update resturants')
                                <td>
                                    <a href="{{route('branches.tables.edit',['branch'=>$branch->id,'table'=>$table->id])}}" class="btn blue"><i class="fa fa-edit"></i>
                                        تعديل
                                    </a>
                                </td>
                                @endcan
                                @can('update resturants')
                                <td>
                                    <button type="button" data-target="#table_{{$table->id}}" data-toggle="modal" class="btn blue"><i class="fa fa-edit"></i>
                                        QR Code
                                    </button>
                                </td>
                                @endcan
                                @can('delete resturants')
                                <td>
                                    @if($table->status != \App\Models\BranchTable::STATE_BUSY)
                                    <form action="{{route('branches.tables.destroy',['branch'=>$branch->id,'table'=>$table->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button type="submit" class="btn red"><i class="fa fa-trash"></i>
                                        حذف
                                    </button>
                                    </form>
                                    @else
                                        مشغولة
                                    @endif

                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@foreach ($tables as $table)
<div class="modal fade" id="table_{{$table->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">طاولة رقم {{$table->number}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="qrCode" data-hash="{{$table->hash}}">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('javascript')
<script type="text/javascript" src="{{asset('qrCode/qrcode.js')}}"></script>

<script>
    $(document).ready(function(){
        var qrCodeDivs = document.getElementsByClassName('qrCode');
        for (let index = 0; index < qrCodeDivs.length; index++) {
            let qrCodeDiv = qrCodeDivs[index];
            let hash = $(qrCodeDiv).data('hash');
            console.log(hash);
            new QRCode(qrCodeDiv, {
                text: hash,
                width: 500,
                height: 500,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });
</script>

@endsection
