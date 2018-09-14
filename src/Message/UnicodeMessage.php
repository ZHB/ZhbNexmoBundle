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

class UnicodeMessage extends AbstractMessage
{
    protected function getType(): string
    {
        return self::TYPE_UNICODE;
    }
}
