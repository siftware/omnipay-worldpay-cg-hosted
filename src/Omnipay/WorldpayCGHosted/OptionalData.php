<?php

namespace Omnipay\WorldpayCGHosted;

class OptionalData
{
    /**
     * @var array properties which have been set values
     */
    private $setProperties = [];

    /**
     * Check if property set
     * @param string $property
     * @return bool
     */
    public function isSet(string $property): bool
    {
        return array_key_exists($property, $this->setProperties);
    }

    /***
     * Check if any properties are set
     * @return bool
     */
    public function hasProperties(): bool
    {
        return count($this->setProperties) !== 0;
    }
    
    /**
     * Mark property as set
     * @param string $property
     * @return void
     */
    protected function setItem(string $property)
    {
        $this->setProperties[$property] = $property;
    }

    /**
     * Block property access if not set
     * @param string $property
     * @return void
     */
    protected function protectGet(string $property)
    {
        if (!$this->isSet($property)) {
            throw new \BadMethodCallException("Property '{$property}' was not set before access");
        }
    }
}