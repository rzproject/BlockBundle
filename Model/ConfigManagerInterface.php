<?php

namespace Rz\BlockBundle\Model;

interface ConfigManagerInterface
{
    public function hasConfigs();

    public function getConfigs();

    public function setConfigs(array $configs);

    public function hasConfig($name);

    public function getConfig($name);

    public function setConfig($name, array $config);
}
