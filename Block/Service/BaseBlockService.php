<?php

namespace Rz\BlockBundle\Block\Service;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Sonata\BlockBundle\Block\BaseBlockService as BlockService;

/**
 * BaseBlockService
 *
 *
 * @author     Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
abstract class BaseBlockService extends BlockService
{
    protected $securityContext;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    public function __construct($name, EngineInterface $templating, SecurityContextInterface $securityContext = null)
    {
        $this->name       = $name;
        $this->templating = $templating;
        $this->securityContext = $securityContext;
    }
}
