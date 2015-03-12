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

use Sonata\BlockBundle\Block\Service\RssBlockService as BaseBlockService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rz\BlockBundle\Block\BlockTemplateProviderInterface;
use Rz\BlockBundle\Model\ConfigManagerInterface;

class RssBlockService extends BaseBlockService implements BlockTemplateProviderInterface
{

    protected $templateConfig;

    public function setTemplateConfig(ConfigManagerInterface $templateConfig){
        $this->templateConfig = $templateConfig;
    }

    public function getTemplateConfig(){
        return $this->templateConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url'      => false,
            'title'    => 'Insert the rss title',
            'mode'     => 'public',
            'template' => 'SonataBlockBundle:Block:block_core_rss.html.twig',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $keys =  array(
            array('url', 'url', array('required' => false, 'attr'=>array('class'=>'span8'))),
            array('title', 'text', array('required' => false, 'attr'=>array('class'=>'span8'))),
            array('mode', 'choice', array(
                'choices' => array(
                    'public' => 'public',
                    'admin'  => 'admin'
                ),
                'attr'=>array('class'=>'span8')
            )),
        );
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array_merge($this->getTemplateChoices($block), $keys)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings[url]')
                ->assertNotNull(array())
                ->assertNotBlank()
            ->end()
            ->with('settings[title]')
                ->assertNotNull(array())
                ->assertNotBlank()
                ->assertLength(array('max' => 50))
            ->end();
    }

    protected function getTemplateChoices($block) {
        $keys = array();
        if($this->templateConfig->hasConfig($block->getType())) {
            $templateChoices = $this->templateConfig->getBlockTemplateChoices($this->templateConfig->getConfig($block->getType()));
            if ($templateChoices) {
                $keys[] = array('template', 'choice', array('choices'=>$templateChoices, 'attr'=>array('class'=>'span8')));
            }
        }

        return $keys;

    }
}
