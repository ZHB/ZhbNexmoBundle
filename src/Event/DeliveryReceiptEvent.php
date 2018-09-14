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

use Symfony\Component\EventDispatcher\Event;
use Zhb\NexmoBundle\Model\DeliveryReceipt;

class DeliveryReceiptEvent extends Event
{
    private $deliveryReceipt;

    public function __construct(DeliveryReceipt $deliveryReceipt)
    {
        $this->deliveryReceipt = $deliveryReceipt;
    }

    /**
     * @return DeliveryReceipt
     */
    public function getDeliveryReceipt()
    {
        return $this->deliveryReceipt;
    }

    /**
     * @param DeliveryReceipt $deliveryReceipt
     */
    public function setDeliveryReceipt($deliveryReceipt)
    {
        $this->deliveryReceipt = $deliveryReceipt;
    }
}
