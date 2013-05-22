<?php


namespace Rz\BlockBundle\Form\Type;

use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockServiceManagerInterface;
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
        if($options['selectpicker_enabled']) {
            $view->vars['attr']['class'] = sprintf("%s rz-block-service-choice", preg_replace('/span[1-9]/', 'span12', $view->vars['attr']['class'] ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array('selectpicker_enabled' => true));
    }
}
