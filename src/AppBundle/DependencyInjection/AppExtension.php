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
            'oauth' => [
                'individual' => [
                    'owner' => [
                        'type' => null,
                        'uuid' => null
                    ],
                    'roles' => null,
                    'enabled' => null
                ],
                'organization' => [
                    'owner' => [
                        'type' => null,
                        'uuid' => null
                    ],
                    'roles' => null,
                    'enabled' => null
                ]
            ],
            'registration' => [
                'individual' => [
                    'owner' => [
                        'type' => null,
                        'uuid' => null
                    ],
                    'roles' => null,
                    'enabled' => null
                ],
                'organization' => [
                    'owner' => [
                        'type' => null,
                        'uuid' => null
                    ],
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
        $loader->load('stats.yml');
        $loader->load('tenants.yml');

        $container->setParameter('ds_log.monolog.processor.app.parameter', $container->getParameter('app'));

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.app.spa.admin', $config['spa']['admin']);
        $container->setParameter('ds_config.configs.app.spa.portal', $config['spa']['portal']);
        $container->setParameter('ds_config.configs.app.oauth.individual.owner.type', $config['oauth']['individual']['owner']['type']);
        $container->setParameter('ds_config.configs.app.oauth.individual.owner.uuid', $config['oauth']['individual']['owner']['uuid']);
        $container->setParameter('ds_config.configs.app.oauth.individual.roles', $config['oauth']['individual']['roles']);
        $container->setParameter('ds_config.configs.app.oauth.individual.enabled', $config['oauth']['individual']['enabled']);
        $container->setParameter('ds_config.configs.app.oauth.organization.owner.type', $config['oauth']['organization']['owner']['type']);
        $container->setParameter('ds_config.configs.app.oauth.organization.owner.uuid', $config['oauth']['organization']['owner']['uuid']);
        $container->setParameter('ds_config.configs.app.oauth.organization.roles', $config['oauth']['organization']['roles']);
        $container->setParameter('ds_config.configs.app.oauth.organization.enabled', $config['oauth']['organization']['enabled']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner.type', $config['registration']['individual']['owner']['type']);
        $container->setParameter('ds_config.configs.app.registration.individual.owner.uuid', $config['registration']['individual']['owner']['uuid']);
        $container->setParameter('ds_config.configs.app.registration.individual.roles', $config['registration']['individual']['roles']);
        $container->setParameter('ds_config.configs.app.registration.individual.enabled', $config['registration']['individual']['enabled']);
        $container->setParameter('ds_config.configs.app.registration.organization.owner.type', $config['registration']['organization']['owner']['type']);
        $container->setParameter('ds_config.configs.app.registration.organization.owner.uuid', $config['registration']['organization']['owner']['uuid']);
        $container->setParameter('ds_config.configs.app.registration.organization.roles', $config['registration']['organization']['roles']);
        $container->setParameter('ds_config.configs.app.registration.organization.enabled', $config['registration']['organization']['enabled']);
    }
}
