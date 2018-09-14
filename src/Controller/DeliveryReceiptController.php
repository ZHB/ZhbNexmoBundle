<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Zhb\NexmoBundle\Event\DeliveryReceiptEvent;
use Zhb\NexmoBundle\Event\ZhbNexmoEvents;
use Zhb\NexmoBundle\Model\DeliveryReceipt;
use Zhb\NexmoBundle\Serializer\NameConverter\DashToCamelCaseNameConverter;

class DeliveryReceiptController extends AbstractController
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * <code>
     * {
     *     "msisdn": "447700900000",
     *     "to": "AcmeInc",
     *     "network-code": "12345",
     *     "messageId": "0A0000001234567B",
     *     "price": "0.03330000",
     *     "status": "delivered",
     *     "scts": "2001011400",
     *     "err-code": "0",
     *     "message-timestamp": "2020-01-01T12:00:00.000+00:00"
     * }
     * </code>
     *
     * @param Request $request
     *
     * @return Response
     */
    public function smsStatusChanged(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $nameConverter = new DashToCamelCaseNameConverter();
            $normalizer = new ObjectNormalizer(null, $nameConverter);
            $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

            $deliveryReceipt = $serializer->deserialize($request->getContent(), DeliveryReceipt::class, 'json');
        } else {
            $deliveryReceipt = DeliveryReceipt::createFromRequest($request);
        }

        $event = new DeliveryReceiptEvent($deliveryReceipt);

        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(ZhbNexmoEvents::SMS_STATUS_CHANGED, $event);
        }

        return $this->json($event->getDeliveryReceipt());
    }
}
