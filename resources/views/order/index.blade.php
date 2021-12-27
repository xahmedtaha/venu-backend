@extends('layouts.adminPanel.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">{{Translator::get('orders')}}</span>
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
                        {{-- <div class="col-md-6">
                            <div class="btn-group">
                                <a href="" id="sample_editable_1_new" class="btn sbold green">
                                    اضافة
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div> --}}
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
                <table class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th> رقم الاوردر </th>
                            <th> المطعم </th>
                            <th> المستخدم </th>
                            <th> العنوان </th>
                            <th> العنوان بالتفصيل </th>
                            <th> علامة مميزة </th>
                            <th> {{Translator::get('date')}} </th>
                            <th> الاجمالى قبل الضريبة و الخصم و التوصيل </th>
                            <th> قيمة الخصم </th>
                            <th> تكلفة التوصيل </th>
                            <th> قيمة الضريبة </th>
                            <th> {{Translator::get('total')}} </th>
                            <th> حالة الاوردر </th>
                            <th> مسح </th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach ($orders as $order)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order_modal_{{$order->id}}">
                                    {{$order->order_number}}
                                </button>
                            </td>
                            <td>{{$order->resturant->display_name}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->address->address}}</td>
                            <td>{{$order->address->building}}</td>
                            <td>{{$order->address->floor}}</td>
                            <td>{{$order->created_at->format('Y-m-d h:i:s a')}}</td>
                            <td>{{$order->subtotal}}</td>
                            <td>{{$order->discount}}</td>
                            <td>{{$order->delivery_cost}}</td>
                            <td>{{$order->tax}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{\App\Models\Order::statusAr[$order->status]}}</td>
                            <td>
                                <form action="{{route('orders.destroy',$order->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn red"><i class="fa fa-trash"></i>حذف </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$orders->links()}}
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<div id="modals">
    @foreach ($orders as $order)
    <div class="modal fade" id="order_modal_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تفاصيل اوردر {{$order->order_number}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة</th>
                                <th>الاجمالى</th>
                                <th>التعليق</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $orderProduct)
                            <tr>
                                <td>{{$orderProduct->product->name_ar}} </td>
                                <td>{{$orderProduct->quantity}} </td>
                                <td>{{$orderProduct->unit_price}} </td>
                                <td>{{$orderProduct->total}} </td>
                                <td>{{$orderProduct->comment}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('javascript')
@endsection
