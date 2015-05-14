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

use Sonata\BlockBundle\Block\Service\RssBlockService as BaseRssBlockService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rz\BlockBundle\Block\BlockTemplateProviderInterface;

class RssBlockService extends BaseRssBlockService
{

    protected $templates;

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
    public function setTemplates($templates)
    {
        $this->templates = $templates;
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
                )
            )),
        );
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array_merge($this->getTemplateChoices(), $keys)
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

    protected function getTemplateChoices() {
        $keys = array();
        if($this->getTemplates()) {
            $keys[] = array('template', 'choice', array('choices'=>$this->getTemplates()));
        }
        return $keys;

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'RSS Reader';
    }
}
