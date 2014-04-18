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

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        //override Text Block from sonata
        $definition = $container->getDefinition('sonata.block.service.text');
        $definition->setClass($container->getParameter('rz_block.service.text.class'));
//        $definition->addArgument(new Reference('security.context'));
//        $container->setDefinition('sonata.block.service.text', $definition);

        //override RSS Block from sonata
        $definition = $container->getDefinition('sonata.block.service.rss');
        $definition->setClass($container->getParameter('rz_block.service.rss.class'));
//        $definition->addArgument(new Reference('security.context'));
//        $container->setDefinition('sonata.block.service.rss', $definition);

        //override sonaa_block
        $definition = $container->getDefinition('sonata.block.templating.helper');
        $definition->setClass($container->getParameter('rz_block.emplating.helper.class'));
        $definition->addArgument(new Reference('security.context'));
        $container->setDefinition('sonata.block.templating.helper', $definition);

    }
}
