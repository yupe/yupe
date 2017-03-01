<?php

/**
 * Class OrderEvents
 */
class OrderEvents
{
    /**
     *
     */
    const CREATED_HTTP = 'http.order.created';

    /**
     *
     */
    const UPDATED_HTTP = 'http.order.updated';

    /**
     *
     */
    const CREATED = 'order.created';

    /**
     *
     */
    const UPDATED = 'order.updated';

    /**
     *
     */
    const SUCCESS_PAID = 'order.pay.success';

    /**
     *
     */
    const FAILURE_PAID = 'order.pay.failure';

    /**
     *
     */
    const STATUS_CHANGED = 'order.status.changed';
} 
