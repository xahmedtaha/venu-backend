@foreach ($orders as $order)
<tr id="order_{{$order->id}}">
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
    <td>
        <select class="form-control status-select" data-id="{{$order->id}}" id="order_status_{{$order->id}}" data-show-subtext="true">
            <option {{$order->status=='0'? 'selected':''}} value="0">معلق</option> ;
            <option {{$order->status=='1'? 'selected':''}} value="1">جارى التحضير</option>;
            <option {{$order->status=='2'? 'selected':''}} value="2">جارى التوصيل</option> ;
            <option {{$order->status=='3'? 'selected':''}} value="3">تم التوصيل</option>;
            <option {{$order->status=='4'? 'selected':''}} value="4">مرفوض</option>;
        </select>
        @php

            switch ($order->status) {
                case 0:
                    $statusSpan = "<span class='label lable-sm label-success'>معلق </span>";
                    break;
                case 1:
                    $statusSpan = "<span class='label lable-sm label-default'>جارى التحضير </span>";
                    break;
                case 2:
                    $statusSpan = "<span class='label lable-sm label-warning'>جارى التوصيل </span>";
                    break;
                case 3:
                    $statusSpan = "<span class='label lable-sm label-info'>تم التوصيل </span>";
                    break;
                case 4:
                    $statusSpan = "<span class='label lable-sm label-danger'>مرفوض< </span>";
                    break;
            }
        @endphp
        {!!$statusSpan!!}
    </td>
    <td>
        <button type="submit" data-id="{{$order->id}}" class="btn red deleteBtn"><i class="fa fa-trash"></i>حذف </button>
    </td>
</tr>



@endforeach
