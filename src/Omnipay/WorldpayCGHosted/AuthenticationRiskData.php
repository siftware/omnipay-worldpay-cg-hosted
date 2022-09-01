<?php

namespace Omnipay\WorldpayCGHosted;

use DateTimeInterface;

class AuthenticationRiskData extends OptionalData
{    
    const AUTHENTICATION_METHOD_GUEST_CHECKOUT = "guestCheckout";
    const AUTHENTICATION_METHOD_LOCAL_ACCOUNT = "localAccount";
    const AUTHENTICATION_METHOD_FEDERATED_ACCOUNT = "federatedAccount";
    const AUTHENTICATION_METHOD_FIDO_AUTHENTICATOR = "fidoAuthenticator";

    /**
     * Date and time that you're submitting the authorisation.
     * @return DateTimeInterface
     */
    public function getAuthenticationTimestamp(): DateTimeInterface
    {
        return $this->protectGet('authenticationTimestamp');
    }

    /**
     * Date and time that you're submitting the authorisation.
     * @param DateTimeInterface $authenticationTimestamp
     */
    public function setAuthenticationTimestamp(DateTimeInterface $authenticationTimestamp)
    {
        $this->setSupportedParameter('authenticationTimestamp', $authenticationTimestamp);
    }

    /**
     * The method used to authenticate the shopper.
     * @return string
     */
    public function getAuthenticationMethod(): string
    {
        return $this->protectGet('authenticationMethod');
    }

    /**
     * The method used to authenticate the shopper.
     * One of the AuthenticationRiskData::AUTHENTICATION_METHOD_ constants
     * @param string $authenticationMethod
     */
    public function setAuthenticationMethod(string $authenticationMethod)
    {
        $this->setSupportedParameter('authenticationMethod', $authenticationMethod);
    }
}