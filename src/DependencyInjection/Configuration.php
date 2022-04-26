<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('documentation');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('openapi')
                ->cannotBeEmpty()
                ->defaultNull()
                ->end()
            ->scalarNode('asyncapi')
                ->cannotBeEmpty()
                ->defaultNull()
                ->end()
            ->arrayNode('swagger_options')
                ->performNoDeepMerging()
                ->defaultValue(array())
                ->variablePrototype()->end()
                ->end()
            ->arrayNode('asyncapi_options')
                ->performNoDeepMerging()
                ->defaultValue(array())
                ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
