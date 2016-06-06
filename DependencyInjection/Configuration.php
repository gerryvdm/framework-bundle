<?php

namespace Netshark\Bundle\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netshark_framework');

        $rootNode
            ->children()
                ->arrayNode('param_converter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('form_type')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('validation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('mappings')
                        	->defaultValue(['%kernel.root_dir%/config/validation'])
                        	->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
