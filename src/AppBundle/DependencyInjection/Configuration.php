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
                ->arrayNode('spa')
                    ->children()
                        ->scalarNode('admin')
                        ->end()
                        ->scalarNode('portal')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('registration')
                    ->children()
                        ->arrayNode('individual')
                            ->children()
                                ->arrayNode('owner')
                                    ->children()
                                        ->scalarNode('type')
                                        ->end()
                                        ->scalarNode('uuid')
                                        ->end()
                                    ->end()
                                ->end()
                                ->scalarNode('roles')
                                ->end()
                                ->scalarNode('enabled')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('organization')
                            ->children()
                                ->arrayNode('owner')
                                    ->children()
                                        ->scalarNode('type')
                                        ->end()
                                        ->scalarNode('uuid')
                                        ->end()
                                    ->end()
                                ->end()
                                ->scalarNode('roles')
                                ->end()
                                ->scalarNode('enabled')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('resetting')
                    ->children()
                        ->arrayNode('email')
                            ->children()
                                ->scalarNode('subject')
                                ->end()
                                ->arrayNode('body')
                                    ->children()
                                        ->scalarNode('plain')
                                        ->end()
                                        ->scalarNode('html')
                                        ->end()
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
