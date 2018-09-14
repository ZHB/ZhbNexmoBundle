<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Event;

final class ZhbNexmoEvents
{
    /**
​     * Called when Nexmo delivery receipt call back url is called.
​     *
​     * @Event("Zhb\NexmoBundle\Event\DeliveryReceiptEvent")
​     */
    const SMS_STATUS_CHANGED = 'zhb_nexmo.sms_status_changed';
}
