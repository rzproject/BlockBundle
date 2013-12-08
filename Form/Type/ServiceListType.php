<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\BlockBundle\Form\Type;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ServiceListType extends AbstractTypeExtension
{

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'sonata_block_service_choice';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        if ($options['selectpicker_enabled']) {
            $view->vars['attr']['class'] = sprintf("%s rz-block-service-choice", preg_replace('/span[1-9]/', 'span12', $view->vars['attr']['class'] ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array('select2' => true));
    }
}
