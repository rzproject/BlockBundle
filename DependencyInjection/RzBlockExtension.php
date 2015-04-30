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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzBlockExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form_type.xml');
        $loader->load('core.xml');
        $loader->load('block.xml');
        $this->configureBlocks($config['blocks'], $container);
        $this->configureClassesToCompile();
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureBlocks($config, ContainerBuilder $container)
    {
        ####################################
        # sonata.block.service.text
        ####################################

        # class
        $container->setParameter('rz_block.block.service.text.class', $config['text']['class']);

        # template
        if($temp = $config['text']['templates']) {
            $templates = array();
            foreach ($temp as $template) {
                $templates[$template['path']] = $template['name'];
            }
            $container->setParameter('rz_block.block.service.text.templates', $templates);
        }


        ####################################
        # sonata.block.service.menu
        ####################################

        # class
        $container->setParameter('rz_block.block.service.menu.class', $config['menu']['class']);

        # template
        if($temp = $config['menu']['templates']) {
            $templates = array();
            foreach ($temp as $template) {
                $templates[$template['path']] = $template['name'];
            }
            $container->setParameter('rz_block.block.service.menu.templates', $templates);
        }


        ####################################
        # sonata.block.service.rss
        ####################################

        # class
        $container->setParameter('rz_blockblock.service.rss.class', $config['rss']['class']);

        # template
        if($temp = $config['rss']['templates']) {
            $templates = array();
            foreach ($temp as $template) {
                $templates[$template['path']] = $template['name'];
            }
            $container->setParameter('rz_block.block.service.rss.templates', $templates);
        }
    }

    /**
     * Add class to compile
     */
    public function configureClassesToCompile()
    {
        $this->addClassesToCompile(array(
            "Rz\\BlockBundle\\Block\\Service\\BaseBlockService",
            "Rz\\BlockBundle\\Block\\Service\\RssBlockService",
            "Rz\\BlockBundle\\Block\\Service\\MenuBlockService",
            "Rz\\BlockBundle\\Block\\Service\\TextBlockService",
            "Rz\\BlockBundle\\Form\\Type\\ServiceListType"
        ));
    }
}
