<?php

namespace Rz\BlockBundle\Model;

use Rz\BlockBundle\Exception\BlockTemplateProviderConfigManagerException;
use Doctrine\ORM\PersistentCollection;

class BlockTemplateProviderConfigManager implements ConfigManagerInterface
{
    /** @var array */
    protected $configs;
    protected $options;
    protected $indices;

    /**
     * Creates a BlockTemplateProvider config manager.
     *
     * @param array $configs The CKEditor configs.
     */
    public function __construct(array $configs = array())
    {
        $this->setConfigs($configs);
        $this->options = array();
        $this->indices= array();
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfigs()
    {
        return !empty($this->configs);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigs(array $configs)
    {
        foreach ($configs as $name => $config) {
            $this->setConfig($name, $config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfig($name)
    {
        return isset($this->configs[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfigInConfigs($name, $config)
    {
        return isset($config[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigInConfigs($name, $config)
    {
        if($this->hasConfigInConfigs($name, $config)) {
            return $config[$name];
        } else {
            return;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($name)
    {
        if (!$this->hasConfig($name)) {
            throw BlockTemplateProviderConfigManagerException::configDoesNotExist($name);
        }

        return $this->configs[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig($name, array $config)
    {
        $this->configs[$name] = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigNames()
    {
        $indexFields =  null;

        foreach ($this->getConfigs() as $index => $config) {
            $indexFields[$index] = $config['label'];
        }
        return $indexFields;
    }

    public function getBlockTemplateChoices($name) {

        $templates = $this->getConfigInConfigs('templates', $name);

        if (!$templates) {
            throw BlockTemplateProviderConfigManagerException::configDoesNotExist($name);
        }

        $choices = array();

        foreach($templates as $key=>$template) {
            $choices[$template['path']] = $template['name'];
        }

        return $choices;
    }
}
