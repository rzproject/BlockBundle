<?php

namespace Rz\BlockBundle\Block\Service;

use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService as BaseMenuBlockService;

use Rz\BlockBundle\Block\BlockTemplateProviderInterface;
use Rz\BlockBundle\Model\ConfigManagerInterface;

/**
 * Class MenuBlockService
 *
 * @package Sonata\BlockBundle\Block\Service
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class MenuBlockService extends BaseMenuBlockService implements BlockTemplateProviderInterface
{

    protected $templateConfig;

    public function setTemplateConfig(ConfigManagerInterface $templateConfig){
        $this->templateConfig = $templateConfig;
    }

    public function getTemplateConfig(){
        return $this->templateConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $responseSettings = array(
            'menu'         => $this->getMenu($blockContext),
            'menu_options' => $this->getMenuOptions($blockContext->getSettings()),
            'block'        => $blockContext->getBlock(),
            'context'      => $blockContext
        );

        if ('private' === $blockContext->getSettings('cache_policy')) {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $responseSettings, $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), $responseSettings, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {

        $keys = array_merge($this->getTemplateChoices($block), $this->getFormSettingsKeys());
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => $keys
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'title'          => $this->getName(),
            'cache_policy'   => 'public',
            'template'       => 'RzBlockBundle:Block:block_core_menu.html.twig',
            'menu_name'      => "",
            'safe_labels'    => false,
            'current_class'  => 'active',
            'first_class'    => false,
            'last_class'     => false,
            'current_uri'    => null,
            'menu_class'     => "list-group",
            'children_class' => "list-group-item",
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Menu';
    }

    /**
     * @return array
     */
    protected function getFormSettingsKeys()
    {
        return array(
            array('title', 'text', array('required' => false, 'attr'=>array('class'=>'span8'))),
            array('cache_policy', 'choice', array('choices' => array('public', 'private'), 'attr'=>array('class'=>'span8'))),
            array('menu_name', 'choice', array('choices' => $this->menus, 'required' => false, 'attr'=>array('class'=>'span8'))),
            array('safe_labels', 'checkbox', array('required' => false)),
            array('current_class', 'text', array('required' => false, 'attr'=>array('class'=>'span6'))),
            array('first_class', 'text', array('required' => false, 'attr'=>array('class'=>'span6'))),
            array('last_class', 'text', array('required' => false, 'attr'=>array('class'=>'span6'))),
            array('menu_class', 'text', array('required' => false, 'attr'=>array('class'=>'span6'))),
            array('children_class', 'text', array('required' => false, 'attr'=>array('class'=>'span6'))),
        );
    }

    protected function getTemplateChoices($block) {
        $keys = array();
        if($this->templateConfig->hasConfig($block->getType())) {
            $templateChoices = $this->templateConfig->getBlockTemplateChoices($this->templateConfig->getConfig($block->getType()));
            if ($templateChoices) {
                $keys[] = array('template', 'choice', array('choices'=>$templateChoices, 'attr'=>array('class'=>'span8')));
            }
        }

        return $keys;

    }
}