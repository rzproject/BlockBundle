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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Sonata\BlockBundle\Block\BlockServiceManagerInterface;

class ServiceListType extends AbstractTypeExtension
{

    protected $manager;

    /**
     * @param BlockServiceManagerInterface $manager
     */
    public function __construct(BlockServiceManagerInterface $manager)
    {
        $this->manager  = $manager;
    }

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
     *
     * @todo Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $manager = $this->manager;

        $resolver->setRequired(array(
            'context',
        ));

        $resolver->setDefaults(array(
            'multiple'          => false,
            'expanded'          => false,
            'choices'           => function (Options $options, $previousValue) use ($manager) {
                $types = array();
                foreach ($manager->getServicesByContext($options['context'], $options['include_containers']) as $code => $service) {
                    $types[$code] = sprintf('%s - %s', $service->getName(), $code);
                }

                return $types;
            },
            'preferred_choices'  => array(),
            'empty_data'         => function (Options $options) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded ? array() : '';
            },
            'empty_value'        => function (Options $options, $previousValue) {
                $multiple = isset($options['multiple']) && $options['multiple'];
                $expanded = isset($options['expanded']) && $options['expanded'];

                return $multiple || $expanded || !isset($previousValue) ? null : '';
            },
            'error_bubbling'     => false,
            'include_containers' => false,
            'select2' => true,
        ));
    }
}
