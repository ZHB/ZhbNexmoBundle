<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class DeliveryReceipt
{
    private $msisdn;

    private $to;

    private $networkCode;

    private $messageId;

    private $price;

    private $status;

    private $scts;

    private $errCode;

    private $messageTimestamp;

    private $clientRef;

    public function getMsisdn()
    {
        return $this->msisdn;
    }

    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getNetworkCode()
    {
        return $this->networkCode;
    }

    public function setNetworkCode($networkCode)
    {
        $this->networkCode = $networkCode;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getScts()
    {
        return $this->scts;
    }

    public function setScts($scts)
    {
        $this->scts = $scts;
    }

    public function getErrCode()
    {
        return $this->errCode;
    }

    public function setErrCode($errCode)
    {
        $this->errCode = $errCode;
    }

    public function getMessageTimestamp()
    {
        return $this->messageTimestamp;
    }

    public function setMessageTimestamp($messageTimestamp)
    {
        $this->messageTimestamp = $messageTimestamp;
    }

    public function getClientRef()
    {
        return $this->clientRef;
    }

    public function setClientRef($clientRef)
    {
        $this->clientRef = $clientRef;
    }

    public static function createFromRequest(Request $request)
    {
        $deliveryReceipt = new self();
        $deliveryReceipt->setErrCode($request->query->get('err-code'));
        $deliveryReceipt->setMessageId($request->query->get('messageId'));
        $deliveryReceipt->setMessageTimestamp($request->query->get('message-timestamp'));
        $deliveryReceipt->setMsisdn($request->query->get('msisdn'));
        $deliveryReceipt->setNetworkCode($request->query->get('network-code'));
        $deliveryReceipt->setPrice($request->query->get('price'));
        $deliveryReceipt->setScts($request->query->get('scts'));
        $deliveryReceipt->setStatus($request->query->get('status'));
        $deliveryReceipt->setTo($request->query->get('to'));
        $deliveryReceipt->setClientRef($request->query->get('client-ref'));

        return $deliveryReceipt;
    }
}
