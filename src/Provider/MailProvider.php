<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Provider;

use Zhb\NexmoBundle\Message\MessageInterface;
use Zhb\NexmoBundle\Response\MailResponse;
use Zhb\NexmoBundle\Response\NoopResponse;

class MailProvider implements ProviderInterface
{
    private const SUBJECT = 'You receive a new SMS';

    private $mailer;

    private $from;

    private $to;

    private $disableDelivery;

    public function __construct(\Swift_Mailer $mailer, string $from, string $to, bool $disableDelivery = false)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
        $this->disableDelivery = $disableDelivery;
    }

    public function send(MessageInterface $message)
    {
        if ($this->disableDelivery) {
            return NoopResponse::createFromResponse(null);
        }

        $swiftMessage = (new \Swift_Message(self::SUBJECT))
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody(sprintf(
                $this->getBody(),
                $message->getTo(),
                json_encode($message->toArray())
            ), 'text/plain')
        ;

        $numSent = $this->mailer->send($swiftMessage, $failures);

        return MailResponse::createFromResponse([$numSent, $failures, $message->getFrom() ?: $this->from, $message->getTo() ?: $this->to]);
    }

    private function getBody()
    {
        return <<<BODY
Hi,

You've just received a new SMS with the following config. to your phone %s :

%s

Regards,
ZhbNexmoBundle
BODY;
    }
}
