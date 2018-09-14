<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zhb\NexmoBundle\DependencyInjection\ZhbNexmoExtension;

class ZhbNexmoBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ZhbNexmoExtension();
        }

        return $this->extension;
    }
}
