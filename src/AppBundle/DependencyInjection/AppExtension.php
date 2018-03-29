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
            'spa' => [
                'admin' => null,
                'portal' => null
            ],
            'registration' => [
                'individual' => [
                    'owner' => null,
                    'owner_uuid' => null,
                    'roles' => null,
                    'enabled' => null
                ],
                'organization' => [
                    'owner' => null,
                    'owner_uuid' => null,
                    'roles' => null,
                    'enabled' => null
                ]
            ],
            'resetting' => [
                'email' => [
                    'subject' => null,
                    'body' => [
                        'plain' => null,
                        'html' => null
                    ]
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

        $container->setParameter('ds_log.monolog.processor.app.parameter', $container->getParameter('app'));

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.app.spa.admin', $config['spa']['admin']);
        $container->setParameter('ds_config.configs.app.spa.portal', $config['spa']['portal']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner_uuid', $config['registration']['individual']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner_uuid', $config['registration']['individual']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.individual.roles', $config['registration']['individual']['roles']);
        $container->setParameter('ds_config.configs.app.registration.individual.enabled', $config['registration']['individual']['enabled']);
        $container->setParameter('ds_config.configs.app.registration.organization.owner_uuid', $config['registration']['organization']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.organization.owner_uuid', $config['registration']['organization']['owner_uuid']);
        $container->setParameter('ds_config.configs.app.registration.organization.roles', $config['registration']['organization']['roles']);
        $container->setParameter('ds_config.configs.app.registration.organization.enabled', $config['registration']['organization']['enabled']);
    }
}
