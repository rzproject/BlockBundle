<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\BlockBundle\Block\Service;

use Sonata\BlockBundle\Block\Service\TextBlockService as BaseBlockService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Validator\ErrorElement;
use Rz\BlockBundle\Block\BlockTemplateProviderInterface;
use Rz\BlockBundle\Model\ConfigManagerInterface;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class TextBlockService extends BaseBlockService implements BlockTemplateProviderInterface
{
    protected $templateConfig;

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $keys = array();

        if($this->templateConfig && $this->templateConfig->hasConfig($block->getType())) {
            $templateChoices = $this->templateConfig->getBlockTemplateChoices($this->templateConfig->getConfig($block->getType()));
            if ($templateChoices) {
                $keys[] = array('template', 'choice', array('choices'=>$templateChoices, 'attr'=>array('class'=>'span8')));
            }
        }
        $keys[] = array('content', 'ckeditor', array('required'=>false, 'config_name'=>'minimal_editor'));
        $formMapper->add('settings', 'sonata_type_immutable_array', array('keys' =>$keys));
    }

    public function setTemplateConfig(ConfigManagerInterface $templateConfig){
        $this->templateConfig = $templateConfig;
    }

    public function getTemplateConfig(){
        return $this->templateConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse($this->getTemplating()->exists($blockContext->getTemplate()) ? $blockContext->getTemplate() : 'RzBlockBundle:Block:block_core_text.html.twig', array(
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings()
        ), $response);
    }
}
