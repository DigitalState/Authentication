<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class AppExtension
 */
class AppExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('app', [
            'registration' => [
                'owner' => null,
                'owner_uuid' => null,
                'individual' => [
                    'owner' => null,
                    'owner_uuid' => null,
                    'roles' => null,
                    'enabled' => null
                ]
            ]
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('api_filters.yml');
        $loader->load('event_listeners.yml');
        $loader->load('repositories.yml');
        $loader->load('security.yml');
        $loader->load('serializers.yml');
        $loader->load('services.yml');

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.app.registration.owner', $config['registration']['owner']);
        $container->setParameter('ds_config.configs.app.registration.owner_uuid', $config['registration']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner_uuid', $config['registration']['individual']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner_uuid', $config['registration']['individual']['owner_uuid']);
    }
}
