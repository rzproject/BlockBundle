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

use Sonata\BlockBundle\Block\Service\TextBlockService as BaseTextBlockService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class TextBlockService extends BaseTextBlockService
{
    protected $templates;

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        if($this->getTemplates()) {
            $keys[] = array('template', 'choice', array('choices'=>$this->getTemplates()));
        }
        $keys[] = array('content', 'ckeditor', array('required'=>false, 'config_name'=>'minimal_editor'));
        $formMapper->add('settings', 'sonata_type_immutable_array', array('keys' =>$keys));
    }

    /**
     * @return mixed
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param mixed $templates
     */
    public function setTemplates($templates = array())
    {
        $this->templates = $templates;
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Text - (Plain Text Core)';
    }
}
