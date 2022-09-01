<?php

namespace Omnipay\WorldpayCGHosted;

use http\Exception\InvalidArgumentException;
use Omnipay\Common\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * ParameterBag with checks on supported properties
 * 
 * Should use \Omnipay\Common\ParametersTrait when minimum omnipay/common supports it
 */
class OptionalData
{
    /**
     * Internal storage of all of the optional parameters.
     * 
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;
    
    /**
     * Create a new OptionalData object using the specified parameters
     *
     * @param array $parameters An array of parameters to set on the new object
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
        
        $unsupportedParameters = array_diff(array_keys($parameters), $this->parameters->keys());
        
        if (count($unsupportedParameters) > 0) {
            $badArgs = implode(", ", array_map(function($arg) { return "'{$arg}'"; }, $unsupportedParameters));
            throw new \InvalidArgumentException("Unsupported parameters {$badArgs}");
        }
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     * @return $this
     */
    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Get all parameters.
     *
     * @return array An associative array of parameters.
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * Get one parameter.
     *
     * @return mixed A single parameter value.
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * Set one parameter.
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     * @return $this
     */
    protected function setParameter($key, $value)
    {        
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * Set one parameter.
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     * @return OptionalData $this
     */
    protected function setSupportedParameter(string $key, $value): OptionalData
    {
        $this->assignedParameters[$key] = $key;

        return $this->setParameter($key, $value);
    }
    
    /**
     * Check if property set
     * @param string $property
     * @return bool
     */
    public function isSet(string $property): bool
    {
        return $this->parameters->has($property);
    }

    /***
     * Check if any properties are set
     * @return bool
     */
    public function hasProperties(): bool
    {
        return $this->parameters->count() > 0;
    }
    
    /**
     * Block property access if not set
     * @param string $property
     * @return mixed
     */
    protected function protectGet(string $property)
    {
        if (!$this->parameters->has($property)) {
            throw new \BadMethodCallException("Property '{$property}' was not set before access");
        }
        return $this->getParameter($property);
    }
}