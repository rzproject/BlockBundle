<?php

namespace Rz\BlockBundle\Block;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Rz\BlockBundle\Model\ConfigManagerInterface;

interface BlockTemplateProviderInterface
{
    public function setTemplateConfig(ConfigManagerInterface $templateConfig);

    public function getTemplateConfig();
}
