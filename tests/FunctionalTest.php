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

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Zhb\NexmoBundle\Provider\SmsProvider;
use Zhb\NexmoBundle\ZhbNexmoBundle;

class FunctionalTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new ZhbNexmoBundleTestingKernel([
            'sms' => [
                'api_key' => 'api_key',
                'api_secret' => 'api_secret',
                'from' => 'from',
            ],
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();

        $sms = $container->get('zhb_nexmo.sms');
        $this->assertInstanceOf(SmsProvider::class, $sms);
    }
}

class ZhbNexmoBundleTestingKernel extends Kernel
{
    private $zhbNexmoConfig;

    public function __construct(array $zhbNexmoConfig = [])
    {
        $this->zhbNexmoConfig = $zhbNexmoConfig;

        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new ZhbNexmoBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function(ContainerBuilder $container) {
            $container->register('mailer', \Swift_Mailer::class);
            $container->loadFromExtension('zhb_nexmo', $this->zhbNexmoConfig);
        });
    }

    public function getCacheDir()
    {
        return __DIR__.'/cache/'.spl_object_hash($this);
    }
}
