<?php

namespace Omnipay\WorldpayCGHosted;

use DateTimeInterface;

class AuthenticationRiskData extends OptionalData
{
    /**
     * @var ?DateTimeInterface 
     */
    private $authenticationTimestamp = null;

    /**
     * @var null|string 
     */
    private $authenticationMethod = null;
    
    const AUTHENTICATION_METHOD_GUEST_CHECKOUT = "guestCheckout";
    const AUTHENTICATION_METHOD_LOCAL_ACCOUNT = "localAccount";
    const AUTHENTICATION_METHOD_FEDERATED_ACCOUNT = "federatedAccount";
    const AUTHENTICATION_METHOD_FIDO_AUTHENTICATOR = "fidoAuthenticator";

    /**
     * Date and time that you're submitting the authorisation.
     * @return null|DateTimeInterface
     */
    public function getAuthenticationTimestamp()
    {
        $this->protectGet('authenticationTimestamp');
        return $this->authenticationTimestamp;
    }

    /**
     * Date and time that you're submitting the authorisation.
     * @param DateTimeInterface $authenticationTimestamp
     */
    public function setAuthenticationTimestamp(DateTimeInterface $authenticationTimestamp)
    {
        $this->setItem('authenticationTimestamp');
        $this->authenticationTimestamp = $authenticationTimestamp;
    }

    /**
     * The method used to authenticate the shopper.
     * @return null|string
     */
    public function getAuthenticationMethod()
    {
        $this->protectGet('authenticationMethod');
        return $this->authenticationMethod;
    }

    /**
     * The method used to authenticate the shopper.
     * One of the AuthenticationRiskData::AUTHENTICATION_METHOD_ constants
     * @param string $authenticationMethod
     */
    public function setAuthenticationMethod(string $authenticationMethod)
    {
        $this->setItem('authenticationMethod');
        $this->authenticationMethod = $authenticationMethod;
    }
}