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
use Symfony\Component\Translation\TranslatorInterface;

class ServiceListType extends AbstractTypeExtension
{

    protected $translator;


    /**
     * @param BlockServiceManagerInterface $manager
     */
    public function __construct(BlockServiceManagerInterface $manager, TranslatorInterface $translator)
    {
        $this->manager  = $manager;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'sonata_block_service_choice';
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
            'multiple'           => false,
            'expanded'           => false,
            'choices'            => function (Options $options, $previousValue) use ($manager) {
                $types = array();
                foreach ($manager->getServicesByContext($options['context'], $options['include_containers']) as $code => $service) {
                    // TODO: from OLD version provide pull request
                    //$types[$code] = sprintf('%s - %s', $service->getName(), $code);
                    $types[$code] = sprintf('%s - %s', $this->translator->trans($service->getBlockMetadata()->getTitle(), array(),  $service->getBlockMetadata()->getDomain()), $code);
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
        ));
    }
}
