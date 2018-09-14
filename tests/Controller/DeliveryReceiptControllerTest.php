<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Zhb\NexmoBundle\ZhbNexmoBundle;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class DeliveryReceiptControllerTest extends TestCase
{
    public function testSmsStatusChanged()
    {
        $kernel = new ZhbNexmoBundleTestingControllerKernel();
        $client = new Client($kernel);
        $client->request('POST', '/nexmo/', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], $this->getPayload());

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertSame('447700900000', $responseData['msisdn']);
        $this->assertSame('AcmeInc', $responseData['to']);
        $this->assertSame('12345', $responseData['networkCode']);
        $this->assertSame('0A0000001234567B', $responseData['messageId']);
        $this->assertSame('0.03330000', $responseData['price']);
        $this->assertSame('delivered', $responseData['status']);
        $this->assertSame('2001011400', $responseData['scts']);
        $this->assertSame('0', $responseData['errCode']);
        $this->assertSame('2020-01-01T12:00:00.000+00:00', $responseData['messageTimestamp']);
    }

    private function getPayload()
    {
        return <<<'JSON'
{
  "msisdn": "447700900000",
  "to": "AcmeInc",
  "network-code": "12345",
  "messageId": "0A0000001234567B",
  "price": "0.03330000",
  "status": "delivered",
  "scts": "2001011400",
  "err-code": "0",
  "message-timestamp": "2020-01-01T12:00:00.000+00:00"
}
JSON;
    }
}

class ZhbNexmoBundleTestingControllerKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new ZhbNexmoBundle(),
        ];
    }

    public function getCacheDir()
    {
        return __DIR__.'/../cache/'.spl_object_hash($this);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__.'/../../src/Resources/config/routes.xml', '/nexmo');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'Hnsz2ikyajd2mslLsm24c',
        ]);

        $c->register('mailer', \Swift_Mailer::class);
    }
}
