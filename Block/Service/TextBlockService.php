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
use Sonata\AdminBundle\Validator\ErrorElement;
use Rz\BlockBundle\Block\BlockTemplateProviderInterface;
use Rz\BlockBundle\Model\ConfigManagerInterface;

class TextBlockService extends BaseBlockService implements BlockTemplateProviderInterface
{
    protected $templateConfig;

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $keys = array();
        if($this->templateConfig->hasConfig($this->getName())) {
            $templateChoices = $this->templateConfig->getBlockTemplateChoices($this->templateConfig->getConfig($this->getName()));
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
}
