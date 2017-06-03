<?php

namespace Ds\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('ds_user');

        $rootNode
            ->children()
                ->arrayNode('services')
                    ->children()
                        ->arrayNode('identities')
                            ->children()
                                ->scalarNode('url')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('registration')
                    ->children()
                        ->scalarNode('user')
                        ->end()
                        ->arrayNode('individual')
                            ->children()
                                ->scalarNode('role')
                                ->end()
                                ->scalarNode('identity')
                                ->end()
                                ->scalarNode('owner')
                                ->end()
                                ->scalarNode('owner_uuid')
                                ->end()
                                ->scalarNode('enabled')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
