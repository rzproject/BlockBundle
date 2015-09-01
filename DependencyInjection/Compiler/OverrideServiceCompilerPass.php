<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\BlockBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Sonata\AdminBundle\Admin\BaseFieldDescription;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        #################################
        # Override Text Block
        #################################
        $definition = $container->getDefinition('sonata.block.service.text');
        $definition->setClass($container->getParameter('rz_block.block.service.text.class'));
        if($container->hasParameter('rz_block.block.service.text.templates')) {
            $definition->addMethodCall('setTemplates', array($container->getParameter('rz_block.block.service.text.templates')));
        }

        #################################
        # Override Menu Block
        #################################
        $definition = $container->getDefinition('sonata.block.service.menu');
        $definition->setClass($container->getParameter('rz_block.block.service.menu.class'));
        if($container->hasParameter('rz_block.block.service.menu.templates')) {
            $definition->addMethodCall('setTemplates', array($container->getParameter('rz_block.block.service.menu.templates')));
        }

        #################################
        # Override RSS Block
        #################################
        $definition = $container->getDefinition('sonata.block.service.rss');
        $definition->setClass($container->getParameter('rz_block.block.service.rss.class'));
        if($container->hasParameter('rz_block.block.service.rss.templates')) {
            $definition->addMethodCall('setTemplates', array($container->getParameter('rz_block.block.service.rss.templates')));
        }

        #################################
        # Override sonata_block
        #################################
        $definition = $container->getDefinition('sonata.block.templating.helper');
        $definition->setClass($container->getParameter('rz_block.templating.helper.class'));
        $definition->addArgument(new Reference('security.context'));
        $container->setDefinition('sonata.block.templating.helper', $definition);
    }
}
