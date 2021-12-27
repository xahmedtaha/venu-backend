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
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">

                    </div>
                </div>

                <table id="table" class="table table-striped table-bordered table-hover order-column">
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


                    </tbody>
                </table>

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<div id="modals">

</div>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.6.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBnAxFAdHcaDzx5u5wZfAeuaKkOxT1Zr0E",
    authDomain: "foodbook-1e57c.firebaseapp.com",
    databaseURL: "https://foodbook-1e57c.firebaseio.com",
    projectId: "foodbook-1e57c",
    storageBucket: "",
    messagingSenderId: "27096173239",
    appId: "1:27096173239:web:95f0fadd80398bf8341b32"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
@endsection
@section('javascript')
<script src="{{asset('assets/global/plugins/ladda/spin.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/ladda/ladda.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/ui-buttons.min.js')}}" type="text/javascript"></script>
{{-- <script src="{{asset('assets/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script> --}}
<script>
var ComponentsBootstrapSelect = function() {
    var n = function() {
        $(".bs-select").selectpicker({
            iconBase: "fa",
            tickIcon: "fa-check"
        })
    };
    return {
        init: function() {
            n()
        }
    }
}();
$(document).ready(function()
{
    var database = firebase.database();
    var resturantsRef = database.ref('restaurants');
    resturantsRef.on('value',function(snapshot){
        getOrders();

        // snapshot.forEach(function (resturantSnapShot)
        // {
        //     resturantSnapShot.forEach(function (orderSnapShot)
        //     {
        //         // if(orderSnapShot.val().orderStatus <= 2) //not delivered or refused
        //         //     updateOrder(orderSnapShot.key,orderSnapShot.val());
        //     });
        // });
        // ComponentsBootstrapSelect.init();
    });

    // $('.status-select').change(function ()
    // {
    //     var orderId = $(this).data('id');
    //     changeOrderStatus(orderId);
    // });

    // $('.deleteBtn').change(function ()
    // {
    //     var orderId = $(this).data('id');
    //     deleteOrder(orderId);
    // });

});

function getOrders()
{
    $.get("{{route('orders.ajax.getOrdersRows')}}",{},function (data)
    {
        $('#table_body').html(data);
    });
    $.get("{{route('orders.ajax.getOrdersModals')}}",{},function (data)
    {
        $('#modals').html(data);
    });

    $(document).on('change','.status-select',function ()
    {
        console.log('change status');
        var orderId = $(this).data('id');
        changeOrderStatus(orderId);
    });

    $(document).on('click','.deleteBtn',function ()
    {
        var orderId = $(this).data('id');
        deleteOrder(orderId);
    });
}

function createRow(order)
{
    console.log("creating row");

    let row = $('<tr id="order_'+order.id+'"></tr>');
    let orderDetailsButton = $('<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order_modal_'+order.id+'">'+order.orderNumber+'</button>');
    let orderNumberCell = $('<td></td>');
    orderNumberCell.append(orderDetailsButton);
    let resturantNameCell = $('<td>'+order.resturantName+'</td>');
    let userNameCell = $('<td>'+order.user.userName+'</td>');
    let addressNameCell = $('<td>'+order.address.addressName+'</td>');
    let addressBuldingCell = $('<td>'+order.address.addressBuilding+'</td>');
    let addressFloorCell = $('<td>'+order.address.addressFloor+'</td>');
    let dateCell = $('<td>'+order.date+'</td>');
    let subtotalCell = $('<td>'+order.subtotal+'</td>');
    let discountCell = $('<td>'+order.discount+'</td>');
    let deliveryCostCell = $('<td>'+order.deliveryCost+'</td>');
    let taxCell = $('<td>'+order.tax+'</td>');
    let totalCell = $('<td>'+order.total+'</td>');
    let statusCell = $('<td></td>');

    let statusSelect = $('<select class="form-control status-select" id="order_status_'+order.id+'" data-show-subtext="true"></select>');

    let pendinOption = '<option value="0" '+' >معلق</option>' ;
    let preparingOption = '<option value="1" '+' >جارى التحضير</option>';
    let onDeiveryOption = '<option value="2" '+' >جارى التوصيل</option>' ;
    let deliveredOption = '<option value="3" '+' >تم التوصيل</option>';
    let rejectedOption ='<option value="4" '+' >مرفوض</option>';



    statusSelect.append([pendinOption,preparingOption,onDeiveryOption,deliveredOption,rejectedOption]);
    statusSelect.val(order.status);
    statusCell.append(statusSelect);
    statusSpan = '';
    switch (order.status) {
        case 0:
            statusSpan = "<span class='label lable-sm label-success'>معلق </span>";
            break;
        case 1:
            statusSpan = "<span class='label lable-sm label-default'>جارى التحضير </span>";
            break;
        case 2:
            statusSpan = "<span class='label lable-sm label-warning'>جارى التوصيل </span>";
            break;
        case 3:
            statusSpan = "<span class='label lable-sm label-info'>تم التوصيل </span>";
            break;
        case 4:
            statusSpan = "<span class='label lable-sm label-danger'>مرفوض< </span>";
            break;
    }
    statusCell.append(statusSpan);

    statusSelect.change(function ()
    {
        changeOrderStatus(order.id);
    });

    let deleteButton = $('<button type="submit" class="btn red"><i class="fa fa-trash"></i>حذف </button>')
    let deleteCell = $("<td></td>");
    deleteCell.append(deleteButton);

    row.append(orderNumberCell);
    row.append(resturantNameCell);
    row.append(userNameCell);
    row.append(addressNameCell);
    row.append(addressBuldingCell);
    row.append(addressFloorCell);
    row.append(dateCell);
    row.append(subtotalCell);
    row.append(discountCell);
    row.append(deliveryCostCell);
    row.append(taxCell);
    row.append(totalCell);
    row.append(statusCell);
    row.append(deleteCell);

    deleteButton.click(function ()
    {
        deleteOrder(order.id);
    });

    $("#table_body").prepend(row);

    createModal(order);
}
function updateOrder(orderId,order)
{
    $.get("orders/"+orderId+"/getOrderDetails",{},function (data)
    {
        let orderRow = $("#order_"+orderId);
        console.log(orderRow);
        console.log("checking order existance");

        if(!orderRow.length)
        {
            console.log("will create row");

            createRow(data);
        }
        else
        {
            console.log("will update row");

            updateRow(data);
        }
    });
}
function updateRow(order)
{
    console.log("creating row");

    let row = $('#order_'+order.id);
    row.html('');
    let orderDetailsButton = $('<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order_modal_'+order.id+'">'+order.orderNumber+'</button>');
    let orderNumberCell = $('<td></td>');
    orderNumberCell.append(orderDetailsButton);
    let resturantNameCell = $('<td>'+order.resturantName+'</td>');
    let userNameCell = $('<td>'+order.user.userName+'</td>');
    let addressNameCell = $('<td>'+order.address.addressName+'</td>');
    let addressBuldingCell = $('<td>'+order.address.addressBuilding+'</td>');
    let addressFloorCell = $('<td>'+order.address.addressFloor+'</td>');
    let dateCell = $('<td>'+order.date+'</td>');
    let subtotalCell = $('<td>'+order.subtotal+'</td>');
    let discountCell = $('<td>'+order.discount+'</td>');
    let deliveryCostCell = $('<td>'+order.deliveryCost+'</td>');
    let taxCell = $('<td>'+order.tax+'</td>');
    let totalCell = $('<td>'+order.total+'</td>');
    let statusCell = $('<td></td>');

    let statusSelect = $('<select class="form-control status-select" id="order_status_'+order.id+'" data-show-subtext="true"></select>');
    let pendinOption = '<option value="0" '+' >معلق</option>' ;
    let preparingOption = '<option value="1" '+' >جارى التحضير</option>';
    let onDeiveryOption = '<option value="2" '+' >جارى التوصيل</option>' ;
    let deliveredOption = '<option value="3" '+' >تم التوصيل</option>';
    let rejectedOption ='<option value="4" '+' >مرفوض</option>';

    statusSelect.append([pendinOption,preparingOption,onDeiveryOption,deliveredOption,rejectedOption]);
    statusCell.append(statusSelect);
    statusSpan = '';
    switch (order.status) {
        case 0:
            statusSpan = "<span class='label lable-sm label-success'>معلق </span>";
            break;
        case 1:
            statusSpan = "<span class='label lable-sm label-default'>جارى التحضير </span>";
            break;
        case 2:
            statusSpan = "<span class='label lable-sm label-warning'>جارى التوصيل </span>";
            break;
        case 3:
            statusSpan = "<span class='label lable-sm label-info'>تم التوصيل </span>";
            break;
        case 4:
            statusSpan = "<span class='label lable-sm label-danger'>مرفوض< </span>";
            break;
    }
    statusCell.append(statusSpan);
    statusSelect.val(order.status);

    statusSelect.change(function ()
    {
        changeOrderStatus(order.id);
    });

    let deleteButton = $('<button type="submit" class="btn red"><i class="fa fa-trash"></i>حذف </button>')
    let deleteCell = $("<td></td>");
    deleteCell.append(deleteButton);

    row.append(orderNumberCell);
    row.append(resturantNameCell);
    row.append(userNameCell);
    row.append(addressNameCell);
    row.append(addressBuldingCell);
    row.append(addressFloorCell);
    row.append(dateCell);
    row.append(subtotalCell);
    row.append(discountCell);
    row.append(deliveryCostCell);
    row.append(taxCell);
    row.append(totalCell);
    row.append(statusCell);
    row.append(deleteCell);

    deleteButton.click(function ()
    {
        deleteOrder(order.id);
    });




}

function createModal(order)
{

    let products = order.products;
    let tableBody = "";
    for(let i = 0; i < products.length; i++)
    {
        let product = products[i];
        tableBody+="<tr>";
        let nameCell = '<td>'+product.productName+'</td>';
        let quantityCell = '<td>'+product.productQuantity+'</td>';
        let priceCell = '<td>'+product.productPrice+'</td>';
        let totalCell = '<td>'+product.productTotal+'</td>';
        let commentCell = '<td>'+product.productComment+'</td>';
        tableBody+= nameCell;
        tableBody+= quantityCell;
        tableBody+= priceCell;
        tableBody+= totalCell;
        tableBody+= commentCell;
        tableBody+="</tr>";
    }
    var modal = ' \
                <div class="modal fade" id="order_modal_'+order.id+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> \
                <div class="modal-dialog" role="document"> \
                    <div class="modal-content"> \
                    <div class="modal-header"> \
                        <h5 class="modal-title" id="exampleModalLabel"> تفاصيل اوردر '+order.orderNumber+'</h5> \
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> \
                        <span aria-hidden="true">&times;</span> \
                        </button> \
                    </div> \
                    <div class="modal-body"> \
                            <table class="table table-striped table-bordered table-hover order-column"> \
                                <thead>\
                                    <tr>\
                                        <th>اسم المنتج</th>\
                                        <th>الكمية</th>\
                                        <th>سعر الوحدة</th>\
                                        <th>الاجمالى</th>\
                                        <th>التعليق</th>\
                                    </tr>\
                                </thead>\
                                <tbody>\
                                    '+tableBody+'\
                                </tbody>\
                    </div> \
                    <div class="modal-footer"> \
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> \
                        <button type="button" class="btn btn-primary">Save changes</button> \
                    </div> \
                    </div> \
                </div> \
                </div>';
    $('#modals').append(modal);
}

function deleteOrder(orderId)
{
    swal({
        title: "هل انت متأكد انك تريد الحذف؟",
        text: "لن تتمكن من التراجع عن هذا الإجراء",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "نعم اريد الحذف!",
        cancelButtonText: "الغاء"
    }).then(result => {
        $.post("{{url('admin/orders')}}/"+orderId,{
        _token : "{{csrf_token()}}",
        _method : "DELETE"
        },function (param)
        {
            $("#order_"+orderId).remove();
            alert('تم حذف الاوردر بنجاح');
        });
    });

}

function changeOrderStatus(orderId)
{
    let statusSelect = $("#order_status_"+orderId);
    let status = statusSelect.val();
    statusSelect.attr('disabled','true');
    $.post("{{url('admin/orders')}}/"+orderId+"/changeStatus",{
        _token : "{{csrf_token()}}",
        status : status
    },function (param)
    {

    });
}
</script>
@endsection
