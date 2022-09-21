<?php

namespace Omnipay\WorldpayCGHosted\Message;

use DOMDocument;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;

/**
 * WorldPay XML Notification - not technically a response but shares
 * most of the same general XML payload structure.
 */
class Notification extends AbstractResponse implements NotificationInterface
{
    use ResponseTrait;

    const RESPONSE_BODY_SUCCESS = '[OK]';       // Must exactly match Worldpay's stated body.
    const RESPONSE_CODE_SUCCESS = 200;          // Must be 200 for Worldpay.
    const RESPONSE_BODY_ERROR   = '[ERROR]';    // Arbitrary not-OK string.
    const RESPONSE_CODE_ERROR   = 500;

    /** @var string */
    private $originIp;

    /** @var bool */
    private $allowIpBasedOriginCheck = true;

    /** @var bool */
    private $allowHostnameBasedOriginCheck = true;

    /** @noinspection PhpMissingParentConstructorInspection
     * @param string                $data
     * @param string                $notificationOriginIp
     * @throws InvalidRequestException on missing or invalid data
     */
    public function __construct($data, $notificationOriginIp)
    {
        $this->originIp = $notificationOriginIp;

        if (!is_string($data)) {
            throw new InvalidRequestException(sprintf('Notification data not a string - got %s', gettype($data)));
        }

        if ($data === '') {
            throw new InvalidRequestException('Notification data empty');
        }

        $responseDom = new DOMDocument;
        if (!@$responseDom->loadXML($data)) {
            throw new InvalidRequestException('Notification data not loaded as XML');
        }

        $document = simplexml_import_dom($responseDom->documentElement);
        $this->data = $document->notify;
    }

    /**
     * Get the most recent Worldpay status string as of this notification,
     * e.g. AUTHORISED, CAPTURED, REFUSED, CANCELLED, ...
     *
     * @link https://bit.ly/wp-cg-notification-statuses Which statuses trigger notifications
     * @link https://bit.ly/wp-cg-payment-process       More detail on the payment process with statuses
     *
     * @return string|null
     */
    public function getStatus()
    {
        if (!$this->hasStatus()) {
            return null;
        }

        return $this->getOrder()->payment->lastEvent->__toString();
    }

    /**
     * @return bool
     */
    public function hasStatus()
    {
        return !empty($this->getOrder()->payment->lastEvent);
    }

    /**
     * @return bool
     */
    public function isAuthorised()
    {
        return ($this->isValid() && $this->isSuccessful());
    }

    /**
     * While this only checks the source host and data structure currently, it might include support for client TLS
     * verification or other checks in the future.
     *
     * @return bool
     */
    public function isValid()
    {
        return ($this->originIsValid() && $this->hasStatus());
    }

    /**
     * Gets the card type code in Worldpay format (e.g. 'ECMC-SSL') if available.
     *
     * @return string|null
     */
    public function getCardType()
    {
        if (empty($this->getOrder()->payment->paymentMethod)) {
            return null;
        }

        return $this->getOrder()->payment->paymentMethod->__toString();
    }

    /**
     * @return string|null
     */
    public function getPaymentTokenID()
    {
        if (empty($this->getTokenDetails())) {
            return null;
        }
        return $this->getTokenDetails()->paymentTokenID->__toString();
    }

    /**
     * @return bool|\DateTimeImmutable
     */
    public function getPaymentTokenExpiry()
    {
        if (null === $this->getTokenDetails()) {
            return false;
        }

        /** @var \SimpleXMLElement $expiryNode */
        $expiryNode = $this->getTokenDetails()->paymentTokenExpiry->date;
        $attributes = $expiryNode->attributes();
        $date = $attributes['year'] . $attributes['month'] . $attributes['dayOfMonth'];
        $time = $attributes['hour'] . $attributes['minute'] . $attributes['second'];

        return \DateTimeImmutable::createFromFormat(
            'Ymj His',
            $date . ' ' . $time
        );
    }

    /**
     * Gets the body of the response your app should provide to the Worldpay bot for this request.
     *
     * @return string
     */
    public function getResponseBody()
    {
        return (
            $this->isValid() ?
                self::RESPONSE_BODY_SUCCESS :
                self::RESPONSE_BODY_ERROR
        );
    }

    /**
     * Gets the HTTP response status code your app should provide to the Worldpay bot for this request.
     *
     * @return int
     */
    public function getResponseStatusCode()
    {
        return (
            $this->isValid() ?
                self::RESPONSE_CODE_SUCCESS :
                self::RESPONSE_CODE_ERROR
        );
    }

    /**
     * @return null|\SimpleXMLElement
     */
    public function getTokenDetails()
    {
        if (null === $this->getToken()) {
            return null;
        }

        if (empty($this->getToken()->tokenDetails)) {
            return null;
        }

        return $this->getToken()->tokenDetails;
    }

    /**
     * Indicates whether the given origin IP address matches *.worldpay.com based on reverse DNS, or IP as a fallback
     * on containers that can't gethostbyaddr().
     *
     * @return bool
     */
    private function originIsValid()
    {
        if (!($this->allowIpBasedOriginCheck || $this->allowHostnameBasedOriginCheck)) {
            return true;
        }

        if (empty($this->originIp)) {
            return false;
        }

        $hostname = @gethostbyaddr($this->originIp);
        if ($this->allowHostnameBasedOriginCheck) {
            if (!$hostname) { // Empty string or boolean false
                return false;
            }

            $expectedEnd = '.worldpay.com';
            $expectedPosition = strlen($hostname) - strlen($expectedEnd);

            if (strpos($hostname, $expectedEnd) === $expectedPosition || $hostname === 'worldpay.com') {
                return true;
            }
        }

        if ($this->allowIpBasedOriginCheck &&
            $this->originIp === $hostname &&
            (
                strpos($hostname, '195.35.90') === 0 ||
                strpos($hostname, '195.35.91') === 0
            )
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return null|\SimpleXMLElement
     */
    private function getToken()
    {
        if (empty($this->getOrder())) {
            return null;
        }

        if (!isset($this->getOrder()->token)) {
            return null;
        }

        return $this->getOrder()->token;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionStatus()
    {
        if (!$this->isValid()) {
            return NotificationInterface::STATUS_FAILED;
        }
        if ($this->isSuccessful())
        {
            return NotificationInterface::STATUS_COMPLETED;
        }
        return NotificationInterface::STATUS_FAILED;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionId(): ?string
    {
        if (empty($this->getOrder())) {
            return null;
        }

        /**
         * @var \SimpleXMLElement $orderStatusEventNode
         */
        $orderStatusEventNode = $this->getOrder();

        if (!isset($orderStatusEventNode['orderCode'])) {
            return null;
        }

        return $orderStatusEventNode['orderCode'];
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference(): ?string
    {
        // WPG uses our unique reference and no other
        return $this->getTransactionId();
    }

    /**
     * Get provider authorisation code
     * @return string|null
     */
    public function getAuthorisationCode(): ?string
    {
        if (empty($this->getOrder())) {
            return null;
        }

        if (empty($this->getOrder()->payment)) {
            return null;
        }

        if (empty($this->getOrder()->payment->AuthorisationId)) {
            return null;
        }

        $authorisationIdNode = $this->getOrder()->payment->AuthorisationId;

        return $authorisationIdNode['id'] ?? null;
    }

    /**
     * Get payment amount
     * @return float|null
     */
    public function getAmount(): ?float
    {
        if (empty($this->getOrder())) {
            return null;
        }

        if (empty($this->getOrder()->payment)) {
            return null;
        }

        if (!isset($this->getOrder()->payment->amount)) {
            return null;
        }

        if (!isset($this->getOrder()->payment->amount['value'])){
            return null;
        }

        $amount = $this->getOrder()->payment->amount['value'];
        if ($this->getOrder()->payment->amount['exponent']) {
            $amount = $amount * pow(10, -($this->getOrder()->payment->amount['exponent']));
        }

        return $amount;
    }

    /**
     * @param bool $allowIpBasedOriginCheck
     * @return Notification
     */
    public function setAllowIpBasedOriginCheck(bool $allowIpBasedOriginCheck): Notification
    {
        $this->allowIpBasedOriginCheck = $allowIpBasedOriginCheck;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowIpBasedOriginCheck(): bool
    {
        return $this->allowIpBasedOriginCheck;
    }

    /**
     * @param bool $allowHostnameBasedOriginCheck
     * @return Notification
     */
    public function setAllowHostnameBasedOriginCheck(bool $allowHostnameBasedOriginCheck): Notification
    {
        $this->allowHostnameBasedOriginCheck = $allowHostnameBasedOriginCheck;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowHostnameBasedOriginCheck(): bool
    {
        return $this->allowHostnameBasedOriginCheck;
    }
}
