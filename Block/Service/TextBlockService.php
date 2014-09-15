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

class TextBlockService extends BaseBlockService
{
    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                //array('content', 'rz_ckeditor', array('required'=>false)),
                array('content', 'ckeditor', array('required'=>false)),
            )
        ));
    }
}
