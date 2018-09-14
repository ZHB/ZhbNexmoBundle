<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Tests\Serializer\NameConverter;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Zhb\NexmoBundle\Serializer\NameConverter\DashToCamelCaseNameConverter;

class DashToCamelCaseNameConverterTest extends TestCase
{
    /**
     * @dataProvider attributeProvider
     */
    public function testDenormalize($dashed, $camelCased)
    {
        $nameConverter = new DashToCamelCaseNameConverter();
        $this->assertEquals($nameConverter->denormalize($dashed), $camelCased);
    }

    public function attributeProvider()
    {
        return [
            ['zhb-nexmoBundle', 'zhbNexmoBundle'],
            ['zhb-nexmo-bundle', 'zhbNexmoBundle'],
            ['zhb-nexmo-Bundle', 'zhbNexmoBundle'],
            ['-zhb-nexmo-Bundle', 'zhbNexmoBundle'],
        ];
    }
}
