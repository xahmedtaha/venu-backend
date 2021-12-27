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
