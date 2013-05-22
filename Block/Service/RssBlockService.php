<?php

namespace Rz\BlockBundle\Block\Service;

use Sonata\BlockBundle\Block\Service\RssBlockService as BaseBlockService;

use Sonata\AdminBundle\Form\FormMapper;

use Sonata\BlockBundle\Model\BlockInterface;

class RssBlockService extends BaseBlockService
{
    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('url', 'url', array('required' => false)),
                array('title', 'text', array('required' => false)),
            )
        ));
    }
}
