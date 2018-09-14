# NexmoBundle

[Nexmo](https://www.nexmo.com) SMS integration for Symfony. This bundle provides a simple service to send SMS from your application.

[![Build Status](https://travis-ci.org/ZHB/ZhbNexmoBundle.svg?branch=master)](https://travis-ci.org/ZHB/ZhbNexmoBundle) 

## Installation

Use [Composer](http://getcomposer.org/) to install NexmoBundle in your project:

```shell
composer require "zhb/nexmo-bundle"
```

## Configuration

First of all, create a [Nexmo](https://www.nexmo.com) account. Next, configure the bundle :

```yaml
# config/packages/zhb_nexmo.yaml

zhb_nexmo:
    provider: 'zhb_nexmo.mail' # (optional) default to zhb_nexmo.sms
    disable_delivery: true # (optional) default to false.
    sms:
        api_key: 'nexmo_api_key'
        api_secret: 'nexmo_api_secret'
        from: 'John Doe'
        ttl: '86400000' # (optional) default to 259200000 ms.
        callback: 'https://website.com/zhb-nexmo/delivery-receipt' # (optional) default to null. This parameter overrides the webhook endpoint you set in Dashboard.
    mail:
        from: 'email@sent.from'
        to: 'email@sent.to'
```

To be able to use Nexmo delivery receipt (DLR) :

```yaml
# config/routes/zhb_nexmo.yaml

_zhb_nexmo:
    resource: '@ZhbNexmoBundle/Resources/config/routes.xml'
    prefix: /zhb-nexmo/delivery-receipt # change as you want
```

To set up the webhook used for incoming messages, use ``zhb_nexmo.sms.callback`` parameter or use the message setter :

```php
$message->setCallback('https://website.com/nexmo/delivery-receipt');
```

Alternatively, you can go to the [your numbers](https://dashboard.nexmo.com/your-numbers) section of the Nexmo Dashboard. Click 'edit' for the virtual number and set the Callback URL (the prefix defined above).

## Usage

### How to send an SMS

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Zhb\NexmoBundle\Message\TextMessage;
use Zhb\NexmoBundle\Provider\MailProvider;
use Zhb\NexmoBundle\Provider\ProviderInterface;
use Zhb\NexmoBundle\Provider\SmsProvider;

class SmsController extends AbstractController
{
    private $provider;

    private $emailProvider;

    private $smsProvider;

    public function __construct(ProviderInterface $provider, MailProvider $emailProvider, SmsProvider $smsProvider)
    {
        $this->provider = $provider; // provider defined in zhb_nexmo.yaml provider key.
        $this->emailProvider = $emailProvider;
        $this->smsProvider = $smsProvider;
    }

    /**
     * @Route("/sms/send", name="sms_send")
     */
    public function send()
    {
        // phone number must be in E.164 format
        $message = new TextMessage('+41798562466', 'Sms message content');
        
        // message setters overrides global config defined in config/packages/zhb_nexmo.yaml
        $message->setFrom('Tom Cruise');
        $message->setTtl(900000); // in milliseconds
        $message->setCallback('https://website.com/zhb-nexmo/delivery-receipt');
        $message->setClientRef('custom_sms_reference');

        $response = $this->provider->send($message);
        var_dump($response);

        $this->emailProvider->send($message);
        $this->smsProvider->send($message);
        
        ...
    }
}

```

### How to listen for SMS delivery receipt (DLR)

```php
<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zhb\NexmoBundle\Event\DeliveryReceiptEvent;
use Zhb\NexmoBundle\Event\ZhbNexmoEvents;

class DeliveryReceiptSubscriber implements EventSubscriberInterface
{
    public function onSmsStatusChanged(DeliveryReceiptEvent $event)
    {
        $deliveryReceipt = $event->getDeliveryReceipt();
        
        ...
    }

    public static function getSubscribedEvents()
    {
        return [
           ZhbNexmoEvents::SMS_STATUS_CHANGED => 'onSmsStatusChanged',
        ];
    }
}

```