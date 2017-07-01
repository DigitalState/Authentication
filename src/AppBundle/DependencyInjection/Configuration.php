<?php

namespace AppBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('app');

        $rootNode
            ->children()
                ->arrayNode('registration')
                    ->children()
                        ->scalarNode('handler')
                        ->end()
                        ->scalarNode('endpoint')
                        ->end()
                        ->arrayNode('individual')
                            ->children()
                                ->scalarNode('roles')
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
