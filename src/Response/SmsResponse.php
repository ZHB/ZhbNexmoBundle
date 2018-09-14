<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Response;

class SmsResponse extends AbstractResponse
{
    private $messageId;

    private $status;

    private $deliveryStatus;

    private $remainingBalance;

    private $price;

    private $network;

    private $to;

    private $from;

    public static function createFromResponse($response)
    {
        $smsResponse = new self();
        $smsResponse->setMessageId($response->getMessageId());
        $smsResponse->setStatus($response->getStatus());
        $smsResponse->setDeliveryStatus($response->getDeliveryStatus());
        $smsResponse->setRemainingBalance($response->getRemainingBalance());
        $smsResponse->setPrice($response->getPrice());
        $smsResponse->setNetwork($response->getNetwork());
        $smsResponse->setTo($response->getTo());
        $smsResponse->setFrom($response->getFrom());

        return $smsResponse;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param mixed $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDeliveryStatus()
    {
        return $this->deliveryStatus;
    }

    /**
     * @param mixed $deliveryStatus
     */
    public function setDeliveryStatus($deliveryStatus)
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    /**
     * @return mixed
     */
    public function getRemainingBalance()
    {
        return $this->remainingBalance;
    }

    /**
     * @param mixed $remainingBalance
     */
    public function setRemainingBalance($remainingBalance)
    {
        $this->remainingBalance = $remainingBalance;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param mixed $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }
}
