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

class MailResponse extends AbstractResponse
{
    private $numSent;

    private $failures;

    private $to;

    private $from;

    public static function createFromResponse($response)
    {
        $smsResponse = new self();
        $smsResponse->setNumSent($response[0]);
        $smsResponse->setFailures($response[1]);
        $smsResponse->setFrom($response[2]);
        $smsResponse->setTo($response[3]);

        return $smsResponse;
    }

    /**
     * @return mixed
     */
    public function getNumSent()
    {
        return $this->numSent;
    }

    /**
     * @param mixed $numSent
     */
    public function setNumSent($numSent)
    {
        $this->numSent = $numSent;
    }

    /**
     * @return mixed
     */
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @param mixed $failures
     */
    public function setFailures($failures)
    {
        $this->failures = $failures;
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
