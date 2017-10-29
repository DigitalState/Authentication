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
        $builder = new TreeBuilder;
        $node = $builder->root('app');
        $node
            ->children()
                ->arrayNode('registration')
                    ->children()
                        ->scalarNode('owner')->end()
                        ->scalarNode('owner_uuid')->end()
                        ->arrayNode('individual')
                            ->children()
                                ->scalarNode('owner')->end()
                                ->scalarNode('owner_uuid')->end()
                                ->scalarNode('roles')->end()
                                ->scalarNode('enabled')->end()
                                ->arrayNode('persona')
                                    ->children()
                                        ->scalarNode('owner')->end()
                                        ->scalarNode('owner_uuid')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
