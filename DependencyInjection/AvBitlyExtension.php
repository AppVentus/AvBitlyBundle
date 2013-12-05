<?php

namespace AppVentus\AvBitlyBundle\DependencyInjection;

use AppVentus\AvBitlyBundle\DependencyInjection\Configuration;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AvBitlyExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //add parameters to container
        $container->setParameter('av_bitly.bitly_token', $config['bitly_token']);
        $container->setParameter('av_bitly.bitly_api_address', $config['bitly_api_address']);
        $container->setParameter('av_bitly.bitly_domain', $config['bitly_domain']);

        $yamlloader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $yamlloader->load('services.yml');
    }
}