<?php

namespace Rz\BlockBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sonata.block.service.text');
        $definition->setClass($container->getParameter('rz_block.service.text.class'));

        $definition = $container->getDefinition('sonata.block.service.rss');
        $definition->setClass($container->getParameter('rz_block.service.rss.class'));

    }
}
