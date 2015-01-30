<?php

namespace Rz\BlockBundle\Exception;

class BlockTemplateProviderConfigManagerException extends \Exception
{
    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name
     *
     * @return \Rz\BlockBundle\Exception The "CONFIG DOES NOT EXIST" exception.
     */
    public static function configDoesNotExist($name)
    {
        return new static(sprintf('The RzBlockBundle config "%s" does not exist.', $name));
    }

    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name
     *
     * @return \Rz\BlockBundle\Exception The "CONFIG DOES NOT EXIST" exception.
     */
    public static function indexDoesNotExist($name)
    {
        return new static(sprintf('The RzBlockBundle index "%s" does not exist.', $name));
    }

    /**
     * Gets the "CONFIG DOES NOT EXIST" exception.
     *
     * @param string $name
     *
     * @return \Rz\BlockBundle\Exception The "CONFIG DOES NOT EXIST" exception.
     */
    public static function optionDoesNotExist($name)
    {
        return new static(sprintf('The RzBlockBundle options "%s" does not exist.', $name));
    }
}
