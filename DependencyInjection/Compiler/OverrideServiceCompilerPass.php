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
        //override Text Block from sonata
        $definition = $container->getDefinition('sonata.block.service.text');
        $definition->setClass($container->getParameter('rz_block.service.text.class'));

        //override Text Block from sonata
        $definition = $container->getDefinition('sonata.block.service.menu');
        $definition->setClass($container->getParameter('rz_block.service.menu.class'));

        //override RSS Block from sonata
        $definition = $container->getDefinition('sonata.block.service.rss');
        $definition->setClass($container->getParameter('rz_block.service.rss.class'));

        //override sonata_block
        $definition = $container->getDefinition('sonata.block.templating.helper');
        $definition->setClass($container->getParameter('rz_block.emplating.helper.class'));
        $definition->addArgument(new Reference('security.context'));
        $container->setDefinition('sonata.block.templating.helper', $definition);

        $keys = array(
            'template_config',
        );

        //find all block services and attached template config for all block implementing  BlockTemplateProviderInterface
        foreach ($container->findTaggedServiceIds('sonata.block') as $id => $attributes) {

            $definition = $container->getDefinition($id);
            foreach ($keys as $key) {
                $method = 'set' . BaseFieldDescription::camelize($key);
                if ($definition->hasMethodCall($method)) {
                    $definition->addMethodCall('setTemplateConfig', array(new Reference('rz_block.config_block_template_provider_manager')));
                }
            }
        }
    }
}
