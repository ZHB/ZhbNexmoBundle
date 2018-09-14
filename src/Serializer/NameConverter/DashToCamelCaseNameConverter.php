<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Serializer\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class DashToCamelCaseNameConverter implements NameConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($propertyName)
    {
        throw new \Exception('normalizer should not be used');
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($propertyName)
    {
        return lcfirst(str_replace('-', '', ucwords($propertyName, '-')));
    }
}
