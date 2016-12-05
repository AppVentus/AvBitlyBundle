<?php

namespace AppVentus\AvBitlyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('av_bitly');

        $rootNode
            ->isRequired()
            ->children()
                ->scalarNode('bitly_token')
                    ->isRequired()
                ->end()
                ->scalarNode('bitly_api_address')
                    ->defaultValue('https://api-ssl.bitly.com')
                ->end()
                ->scalarNode('bitly_domain')
                    ->defaultValue(null)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
