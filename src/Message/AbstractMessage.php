<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Message;

use Zhb\NexmoBundle\Exception\NexmoException;

abstract class AbstractMessage implements MessageInterface
{
    protected const TYPE_TEXT = 'text';

    protected const TYPE_UNICODE = 'unicode';

    protected $from;

    protected $to;

    protected $text;

    protected $ttl;

    protected $callback;

    protected $type;

    protected $clientRef;

    abstract protected function getType(): string;

    public function __construct(string $to, string $text)
    {
        $this->to = $to;
        $this->text = $text;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getCallback(): string
    {
        return $this->callback;
    }

    public function setCallback(string $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function getClientRef(): string
    {
        return $this->clientRef;
    }

    public function setClientRef(string $clientRef): self
    {
        if (40 < strlen($clientRef)) {
            throw new NexmoException('Client-ref must be up to 40 characters.');
        }

        $this->clientRef = $clientRef;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'from' => $this->from,
            'to' => $this->to,
            'text' => $this->text,
            'ttl' => $this->ttl,
            'callback' => $this->callback,
            'type' => $this->getType(),
            'client-ref' => $this->clientRef,
        ];

        return array_filter($data);
    }
}
