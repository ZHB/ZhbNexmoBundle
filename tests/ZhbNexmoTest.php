<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Tests;

use Nexmo\Message\Unicode;
use PHPUnit\Framework\TestCase;
use Zhb\NexmoBundle\Exception\NexmoException;
use Zhb\NexmoBundle\Message\TextMessage;
use Zhb\NexmoBundle\Message\UnicodeMessage;
use Zhb\NexmoBundle\Provider\SmsProvider;
use Zhb\NexmoBundle\Response\SmsResponse;

class ZhbNexmoTest extends TestCase
{
    public function testSendTextMessageSuccess()
    {
        $smsProvider = $this->getMockBuilder(SmsProvider::class)
            ->setConstructorArgs(['api_key', 'api_secret', 'from'])
            ->getMock()
        ;

        $response = new SmsResponse();
        $response->setStatus(0);

        $smsProvider->expects($this->once())
            ->method('send')
            ->will($this->returnValue($response));

        $textMessage = new TextMessage('to_number', 'testCase message');
        $result = $smsProvider->send($textMessage);

        $this->assertEquals(0, $result->getStatus());
    }

    public function testSendUnicodeMessageSuccess()
    {
        $smsProvider = $this->getMockBuilder(SmsProvider::class)
            ->setConstructorArgs(['api_key', 'api_secret', 'from'])
            ->getMock()
        ;

        $response = new SmsResponse();
        $response->setStatus(0);

        $smsProvider->expects($this->once())
            ->method('send')
            ->will($this->returnValue($response));

        $textMessage = new UnicodeMessage('to_number', 'testCase message');
        $result = $smsProvider->send($textMessage);

        $this->assertEquals(0, $result->getStatus());
    }

    public function testSendSmsError()
    {
        $this->expectException(NexmoException::class);

        $message = new TextMessage('to_number', 'testCase message');
        $smsProvider = new SmsProvider('api_key', 'api_secret', 'from');
        $smsProvider->send($message);
    }
}
