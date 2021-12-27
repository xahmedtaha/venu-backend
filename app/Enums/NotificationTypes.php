<?php
namespace App\Enums;

abstract class NotificationTypes
{
    const ORDER_CHANGE_STATUS_CUSTOMER = 1;
    const ADMIN_TO_CUSTOMER = 2;
    const RESTAURANT_OFFER_CUSTOMER = 3;
    const ORDER_ASSIGNED_TO_RESTAURANT = 4;
}
 