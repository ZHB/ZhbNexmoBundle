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

use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;
use Zhb\NexmoBundle\Exception\NexmoException;
use Zhb\NexmoBundle\Message\MessageInterface;
use Zhb\NexmoBundle\Response\AbstractResponse;
use Zhb\NexmoBundle\Response\NoopResponse;
use Zhb\NexmoBundle\Response\SmsResponse;

class SmsProvider implements ProviderInterface
{
    private $apiKey;

    private $apiSecret;

    private $from;

    private $disableDelivery;

    private $ttl;

    private $callback;

    public function __construct(string $apiKey, string $apiSecret, string $from, bool $disableDelivery = false, int $ttl = 259200000, $callback = null)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->from = $from;
        $this->disableDelivery = $disableDelivery;
        $this->ttl = $ttl;
        $this->callback = $callback;
    }

    public function send(MessageInterface $message): AbstractResponse
    {
        if ($this->disableDelivery) {
            return NoopResponse::createFromResponse(null);
        }

        try {
            $client = new Client(new Basic($this->apiKey, $this->apiSecret));
            $message = $client->message()->send($this->mergeConfig($message));
        } catch (Client\Exception\Request $e) {
            throw new NexmoException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return SmsResponse::createFromResponse($message);
    }

    /**
     * Merge global config with message config. Message config overrides global config.
     *
     * @param MessageInterface $message
     *
     * @return array
     */
    public function mergeConfig(MessageInterface $message): array
    {
        $config = array_merge([
            'from' => $this->from,
            'ttl' => $this->ttl,
            'callback' => $this->callback,
        ], $message->toArray());

        return array_filter($config);
    }
}
