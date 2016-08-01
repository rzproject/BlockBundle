<?php

namespace Rz\BlockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('rz_block');

        $this->addBlock($node);

        return $treeBuilder;
    }

    private function addBlock(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('github_rss')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('block')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Rz\\BlockBundle\\Block\\GtihubRssBlockService')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
