<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rz_block');
        $this->addBlockSettings($rootNode);
        return $treeBuilder;
    }
    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addBlockSettings(ArrayNodeDefinition $node) {
        $node
            ->children()
                ->arrayNode('blocks')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('text')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\BlockBundle\\Block\\Service\\TextBlockService')->end()
                                ->arrayNode('templates')
                                    ->useAttributeAsKey('id')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('name')->defaultValue('default')->end()
                                            ->scalarNode('path')->defaultValue('RzBlockBundle:Block:block_core_text.html.twig')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('rss')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\BlockBundle\\Block\\Service\\RssBlockService')->end()
                                ->arrayNode('templates')
                                    ->useAttributeAsKey('id')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('name')->defaultValue('default')->end()
                                            ->scalarNode('path')->defaultValue('RzBlockBundle:Block:block_core_rss.html.twig')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('menu')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\BlockBundle\\Block\\Service\\MenuBlockService')->end()
                                ->arrayNode('templates')
                                    ->useAttributeAsKey('id')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('name')->defaultValue('default')->end()
                                            ->scalarNode('path')->defaultValue('RzBlockBundle:Block:block_core_menu.html.twig')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

}
