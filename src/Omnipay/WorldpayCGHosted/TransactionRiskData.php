<?php

namespace Omnipay\WorldpayCGHosted;

use DateTimeInterface;

class TransactionRiskData extends OptionalData
{
    /**
     * @var null|float 
     */
    private $transactionRiskDataGiftCardAmount = null;

    /**
     * @var null|DateTimeInterface
     */
    private $transactionRiskDataPreOrderDate = null;

    /**
     * @var null|string
     */
    private $shippingMethod = null;

    /**
     * @var null|string
     */    
    private $deliveryTimeframe = null;

    /**
     * @var null|string
     */
    private $deliveryEmailAddress = null;


    /**
     * @var null|bool
     */
    private $reorderingPreviousPurchases = null;
    
    /**
     * @var null|bool
     */
    private $preOrderPurchase = null;
    
    /**
     * @var null|int
     */
    private $giftCardCount = null;

    const SHIPPING_METHOD_SHIP_TO_BILLING_ADDRESS = 'shipToBillingAddress';
    const SHIPPING_METHOD_SHIP_TO_VERIFIED_ADDRESS = 'shipToVerifiedAddress';
    const SHIPPING_METHOD_SHIP_TO_OTHER_ADDRESS = 'shipToOtherAddress';
    const SHIPPING_METHOD_SHIP_TO_STORE = 'shipToStore';
    const SHIPPING_METHOD_DIGITAL = 'digital';
    const SHIPPING_METHOD_UNSHIPPED_TRAVEL_OR_EVENT_TICKETS = 'unshippedTravelOrEventTickets';
    const SHIPPING_METHOD_OTHER = 'other';

    const DELIVERY_TIMEFRAME_ELECTRONIC_DELIVERY = 'electronicDelivery';
    const DELIVERY_TIMEFRAME_SAME_DAY_SHIPPING = 'sameDayShipping';
    const DELIVERY_TIMEFRAME_OVERNIGHT_SHIPPING = 'overnightShipping';
    const DELIVERY_TIMEFRAME_OTHER_SHIPPING = 'otherShipping';

    /**
     * For prepaid or gift card purchase, the purchase amount total of prepaid or gift card(s) in major units (for example, USD 123.45 is 123
     * @return float|null
     */
    public function getTransactionRiskDataGiftCardAmount(): float
    {
        $this->protectGet('transactionRiskDataGiftCardAmount');
        return $this->transactionRiskDataGiftCardAmount;
    }

    /**
     * For prepaid or gift card purchase, the purchase amount total of prepaid or gift card(s) in major units (for example, USD 123.45 is 123
     * @param float|null $transactionRiskDataGiftCardAmount
     */
    public function setTransactionRiskDataGiftCardAmount(float $transactionRiskDataGiftCardAmount)
    {
        $this->setItem('transactionRiskDataGiftCardAmount');
        $this->transactionRiskDataGiftCardAmount = $transactionRiskDataGiftCardAmount;
    }

    /**
     * For a pre-ordered purchase, the expected date that the merchandise will be available.
     * @return DateTimeInterface|null
     */
    public function getTransactionRiskDataPreOrderDate(): DateTimeInterface
    {
        $this->protectGet('transactionRiskDataPreOrderDate');
        return $this->transactionRiskDataPreOrderDate;
    }

    /**
     * For a pre-ordered purchase, the expected date that the merchandise will be available.
     * @param DateTimeInterface|null $transactionRiskDataPreOrderDate
     */
    public function setTransactionRiskDataPreOrderDate(DateTimeInterface $transactionRiskDataPreOrderDate)
    {
        $this->setItem('transactionRiskDataPreOrderDate');
        $this->transactionRiskDataPreOrderDate = $transactionRiskDataPreOrderDate;
    }

    /**
     * Indicates shipping method chosen for the transaction.
     * @return string|null
     */
    public function getShippingMethod(): string
    {
        $this->protectGet('shippingMethod');
        return $this->shippingMethod;
    }

    /**
     * Indicates shipping method chosen for the transaction.
     * One of the TransactionRiskData::SHIPPING_METHOD_ constants
     * @param string|null $shippingMethod
     */
    public function setShippingMethod(string $shippingMethod)
    {
        $this->setItem('shippingMethod');
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * Indicates the delivery timeframe.
     * @return string|null
     */
    public function getDeliveryTimeframe(): string
    {
        $this->protectGet('deliveryTimeframe');
        return $this->deliveryTimeframe;
    }

    /**
     * Indicates the delivery timeframe.
     * One of the TransactionRiskData::DELIVERY_TIMEFRAME_ constants
     * @param string|null $deliveryTimeframe
     */
    public function setDeliveryTimeframe(string $deliveryTimeframe)
    {
        $this->setItem('deliveryTimeframe');
        $this->deliveryTimeframe = $deliveryTimeframe;
    }

    /**
     * For electronically delivered goods only. Email address to which the merchandise was delivered.
     * @return string|null
     */
    public function getDeliveryEmailAddress(): string
    {
        $this->protectGet('deliveryEmailAddress');
        return $this->deliveryEmailAddress;
    }

    /**
     * For electronically delivered goods only. Email address to which the merchandise was delivered.
     * @param string|null $deliveryEmailAddress
     */
    public function setDeliveryEmailAddress(string $deliveryEmailAddress)
    {
        $this->setItem('deliveryEmailAddress');
        $this->deliveryEmailAddress = $deliveryEmailAddress;
    }

    /**
     * Indicates whether the shopper is reordering previously purchased merchandise.
     * @return bool|null
     */
    public function getReorderingPreviousPurchases(): bool
    {
        $this->protectGet('reorderingPreviousPurchases');
        return $this->reorderingPreviousPurchases;
    }

    /**
     * Indicates whether the shopper is reordering previously purchased merchandise.
     * @param bool|null $reorderingPreviousPurchases
     */
    public function setReorderingPreviousPurchases(bool $reorderingPreviousPurchases)
    {
        $this->setItem('reorderingPreviousPurchases');
        $this->reorderingPreviousPurchases = $reorderingPreviousPurchases;
    }

    /**
     * Indicates whether shopper is placing an order with a future availability or release date.
     * @return bool|null
     */
    public function getPreOrderPurchase(): bool
    {
        $this->protectGet('preOrderPurchase');
        return $this->preOrderPurchase;
    }

    /**
     * Indicates whether shopper is placing an order with a future availability or release date.
     * @param bool|null $preOrderPurchase
     */
    public function setPreOrderPurchase(bool $preOrderPurchase)
    {
        $this->setItem('preOrderPurchase');
        $this->preOrderPurchase = $preOrderPurchase;
    }

    /**
     * Total count of individual prepaid gift cards purchased.
     * @return int|null
     */
    public function getGiftCardCount(): int
    {
        $this->protectGet('giftCardCount');
        return $this->giftCardCount;
    }

    /**
     * Total count of individual prepaid gift cards purchased.
     * @param int|null $giftCardCount
     */
    public function setGiftCardCount(int $giftCardCount)
    {
        $this->setItem('giftCardCount');
        $this->giftCardCount = $giftCardCount;
    }
}