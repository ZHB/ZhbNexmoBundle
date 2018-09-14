<?php

/*
 * This file is part of the zhb/nexmo-bundle package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\NexmoBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ZhbNexmoExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['sms'])) {
            $definition = $container->getDefinition('zhb_nexmo.sms');
            $definition->setArgument(0, $config['sms']['api_key']);
            $definition->setArgument(1, $config['sms']['api_secret']);
            $definition->setArgument(2, $config['sms']['from']);
            $definition->setArgument(3, $config['disable_delivery']);
            $definition->setArgument(4, $config['sms']['ttl']);
            $definition->setArgument(5, $config['sms']['callback']);
        }

        if (isset($config['mail'])) {
            $definition = $container->getDefinition('zhb_nexmo.mail');
            $definition->setArgument(1, $config['mail']['from']);
            $definition->setArgument(2, $config['mail']['to']);
            $definition->setArgument(3, $config['disable_delivery']);
        }

        $container->setAlias('zhb_nexmo', $config['provider']);
    }

    public function getAlias()
    {
        return 'zhb_nexmo';
    }
}
