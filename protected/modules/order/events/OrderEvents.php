<?php

class OrderEvents
{
    const SUCCESS_CREATED = 'order.create.success';

    const SUCCESS_PAID = 'order.pay.success';

    const FAILURE_PAID = 'order.pay.failure';

    const STATUS_CHANGED = 'order.status.changed';
} 
