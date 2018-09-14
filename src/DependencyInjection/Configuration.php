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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zhb_nexmo');
        $rootNode
            ->children()
                ->scalarNode('provider')
                    ->defaultValue('zhb_nexmo.sms')
                    ->validate()
                        ->ifNotInArray(['zhb_nexmo.sms', 'zhb_nexmo.mail'])
                        ->thenInvalid('Invalid provider id. Allowed providers are zhb_nexmo.sms, zhb_nexmo.mail')
                    ->end()
                ->end()
                ->booleanNode('disable_delivery')
                    ->defaultValue(false)
                ->end()
                ->arrayNode('sms')
                    ->children()
                        ->scalarNode('api_key')
                            ->isRequired()
                            ->info('Your API key.')
                        ->end()
                        ->scalarNode('api_secret')
                            ->isRequired()
                            ->info('Your API secret.')
                        ->end()
                        ->scalarNode('from')
                            ->isRequired()
                            ->info('The name or number the message should be sent from.')
                        ->end()
                        ->scalarNode('ttl')
                            ->defaultValue(259200000)
                            ->info('The duration in milliseconds the delivery of an SMS will be attempted.')
                        ->end()
                        ->scalarNode('callback')
                            ->defaultNull()
                            ->info('The webhook endpoint the delivery receipt for this sms is sent to. This parameter overrides the webhook endpoint you set in Dashboard.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('mail')
                    ->children()
                        ->scalarNode('from')
                    ->end()
                        ->scalarNode('to')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
