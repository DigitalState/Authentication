<?php

namespace Ds\Bundle\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ConfigPass
 */
class ConfigPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_config.collection.config')) {
            return;
        }

        $definition = $container->findDefinition('ds_config.collection.config');
        $definition->addMethodCall('set', ['ds_user.services.identities.url', $container->getParameter('ds_user.services.identities.url')]);
    }
}
