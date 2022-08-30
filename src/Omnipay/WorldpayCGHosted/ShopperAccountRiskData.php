<?php

namespace Omnipay\WorldpayCGHosted;

use DateTimeInterface;

class ShopperAccountRiskData extends OptionalData
{
    /**
     * @var null|DateTimeInterface
     */
    private $shopperAccountCreationDate = null;

    /**
     * @var null|DateTimeInterface
     */
    private $shopperAccountModificationDate = null;

    /**
     * @var null|DateTimeInterface
     */
    private $shopperAccountPasswordChangeDate = null;

    /**
     * @var null|DateTimeInterface
     */
    private $shopperAccountShippingAddressFirstUseDate = null;

    /**
     * @var null|DateTimeInterface
     */
    private $shopperAccountPaymentAccountFirstUseDate = null;

    /**
     * @var int
     */
    private $transactionsAttemptedLastDay = null;

    /**
     * @var int
     */
    private $transactionsAttemptedLastYear = null;

    /**
     * @var int
     */
    private $purchasesCompletedLastSixMonths = null;

    /**
     * @var int
     */
    private $addCardAttemptsLastDay = null;

    /**
     * @var bool
     */
    private $previousSuspiciousActivity = null;

    /**
     * @var bool
     */
    private $shippingNameMatchesAccountName = null;

    /**
     * @var null|string
     */
    private $shopperAccountAgeIndicator = null;

    /**
     * @var null|string
     */
    private $shopperAccountChangeIndicator = null;

    /**
     * @var null|string
     */
    private $shopperAccountPasswordChangeIndicator = null;

    /**
     * @var null|string
     */
    private $shopperAccountShippingAddressUsageIndicator = null;

    /**
     * @var null|string
     */
    private $shopperAccountPaymentAccountIndicator = null;

    const SHOPPER_ACCOUNT_AGE_INDICATOR_NO_ACCOUNT = 'noAccount';
    const SHOPPER_ACCOUNT_AGE_INDICATOR_CREATED_DURING_TRANSACTION = 'createdDuringTransaction';
    const SHOPPER_ACCOUNT_AGE_INDICATOR_LESS_THAN_THIRTY_DAYS = 'lessThanThirtyDays';
    const SHOPPER_ACCOUNT_AGE_INDICATOR_THIRTY_TO_SIXTY_DAYS = 'thirtyToSixtyDays';
    const SHOPPER_ACCOUNT_AGE_INDICATOR_MORE_THAN_SIXTY_DAYS = 'moreThanSixtyDays';

    const SHOPPER_ACCOUNT_CHANGE_INDICATOR_CHANGED_DURING_TRANSACTION = 'changedDuringTransaction';
    const SHOPPER_ACCOUNT_CHANGE_INDICATOR_LESS_THAN_THIRTY_DAYS = 'lessThanThirtyDays';
    const SHOPPER_ACCOUNT_CHANGE_INDICATOR_THIRTY_TO_SIXTY_DAYS = 'thirtyToSixtyDays';
    const SHOPPER_ACCOUNT_CHANGE_INDICATOR_MORE_THAN_SIXTY_DAYS = 'moreThanSixtyDays';

    const SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_NO_CHANGE = 'noChange';
    const SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_CHANGED_DURING_TRANSACTION = 'changedDuringTransaction';
    const SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_LESS_THAN_THIRTY_DAYS = 'lessThanThirtyDays';
    const SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_THIRTY_TO_SIXTY_DAYS = 'thirtyToSixtyDays';
    const SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_MORE_THAN_SIXTY_DAYS = 'moreThanSixtyDays';
    
    const SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_THIS_TRANSACTION = 'thisTransaction';
    const SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_LESS_THAN_THIRTY_DAYS = 'lessThanThirtyDays';
    const SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_THIRTY_TO_SIXTY_DAYS = 'thirtyToSixtyDays';
    const SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_MORE_THAN_SIXTY_DAYS = 'morethansixtydays';
    
    const SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_NO_ACCOUNT = 'noAccount';
    const SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_DURING_TRANSACTION = 'duringTransaction';
    const SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_LESS_THAN_THIRTY_DAYS = 'lessThanThirtyDays';
    const SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_THIRTY_TO_SIXTY_DAYS = 'thirtyToSixtyDays';
    const SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_MORE_THAN_SIXTY_DAYS = 'moreThanSixtyDays';

    /**
     * Date that the shopper opened the account with the merchant.
     * @return null|DateTimeInterface
     */
    public function getShopperAccountCreationDate()
    {
        $this->protectGet('shopperAccountCreationDate');
        return $this->shopperAccountCreationDate;
    }

    /**
     * Date that the shopper opened the account with the merchant.
     * @param DateTimeInterface $shopperAccountCreationDate
     */
    public function setShopperAccountCreationDate(DateTimeInterface $shopperAccountCreationDate)
    {
        $this->setItem('shopperAccountCreationDate');
        $this->shopperAccountCreationDate = $shopperAccountCreationDate;
    }

    /**
     * Date that the shopper's account with the merchant was last changed, including Billing or Shipping address, new payment account, or new user(s) added.
     * @return null|DateTimeInterface
     */
    public function getShopperAccountModificationDate()
    {
        $this->protectGet('shopperAccountModificationDate');
        return $this->shopperAccountModificationDate;
    }

    /**
     * Date that the shopper's account with the merchant was last changed, including Billing or Shipping address, new payment account, or new user(s) added.
     * @param DateTimeInterface $shopperAccountModificationDate
     */
    public function setShopperAccountModificationDate(DateTimeInterface $shopperAccountModificationDate)
    {
        $this->setItem('shopperAccountModificationDate');
        $this->shopperAccountModificationDate = $shopperAccountModificationDate;
    }

    /**
     * Date that shopper's account with the merchant had a password change or account reset.
     * @return null|DateTimeInterface
     */
    public function getShopperAccountPasswordChangeDate()
    {
        $this->protectGet('shopperAccountPasswordChangeDate');
        return $this->shopperAccountPasswordChangeDate;
    }

    /**
     * Date that shopper's account with the merchant had a password change or account reset.
     * @param DateTimeInterface $shopperAccountPasswordChangeDate
     */
    public function setShopperAccountPasswordChangeDate(DateTimeInterface $shopperAccountPasswordChangeDate)
    {
        $this->setItem('shopperAccountPasswordChangeDate');
        $this->shopperAccountPasswordChangeDate = $shopperAccountPasswordChangeDate;
    }

    /**
     * Indicates when the shipping address used for the transaction was first used.
     * @return DateTimeInterface
     */
    public function getShopperAccountShippingAddressFirstUseDate()
    {
        $this->protectGet('shopperAccountShippingAddressFirstUseDate');
        return $this->shopperAccountShippingAddressFirstUseDate;
    }

    /**
     * Indicates when the shipping address used for the transaction was first used.
     * @param DateTimeInterface $shopperAccountShippingAddressFirstUseDate
     */
    public function setShopperAccountShippingAddressFirstUseDate(DateTimeInterface $shopperAccountShippingAddressFirstUseDate)
    {
        $this->setItem('shopperAccountShippingAddressFirstUseDate');
        $this->shopperAccountShippingAddressFirstUseDate = $shopperAccountShippingAddressFirstUseDate;
    }

    /**
     * Date the payment account was added to the shopper account.
     * @return null|DateTimeInterface
     */
    public function getShopperAccountPaymentAccountFirstUseDate()
    {
        $this->protectGet('shopperAccountPaymentAccountFirstUseDate');
        return $this->shopperAccountPaymentAccountFirstUseDate;
    }

    /**
     * Date the payment account was added to the shopper account.
     * @param DateTimeInterface $shopperAccountPaymentAccountFirstUseDate
     */
    public function setShopperAccountPaymentAccountFirstUseDate(DateTimeInterface $shopperAccountPaymentAccountFirstUseDate)
    {
        $this->setItem('shopperAccountPaymentAccountFirstUseDate');
        $this->shopperAccountPaymentAccountFirstUseDate = $shopperAccountPaymentAccountFirstUseDate;
    }

    /**
     * Number of transactions (successful and abandoned) for this shopper account with the merchant across all payment accounts in the previous 24 hours.
     * @return null|int
     */
    public function getTransactionsAttemptedLastDay()
    {
        $this->protectGet('transactionsAttemptedLastDay');
        return $this->transactionsAttemptedLastDay;
    }

    /**
     * Number of transactions (successful and abandoned) for this shopper account with the merchant across all payment accounts in the previous 24 hours.
     * @param int $transactionsAttemptedLastDay
     */
    public function setTransactionsAttemptedLastDay(int $transactionsAttemptedLastDay)
    {
        $this->setItem('transactionsAttemptedLastDay');
        $this->transactionsAttemptedLastDay = $transactionsAttemptedLastDay;
    }

    /**
     * Number of transactions (successful and abandoned) for this shopper account with the merchant across all payment accounts in the previous year.
     * @return null|int
     */
    public function getTransactionsAttemptedLastYear()
    {
        $this->protectGet('transactionsAttemptedLastYear');
        return $this->transactionsAttemptedLastYear;
    }

    /**
     * Number of transactions (successful and abandoned) for this shopper account with the merchant across all payment accounts in the previous year.
     * @param int $transactionsAttemptedLastYear
     */
    public function setTransactionsAttemptedLastYear(int $transactionsAttemptedLastYear)
    {
        $this->setItem('transactionsAttemptedLastYear');
        $this->transactionsAttemptedLastYear = $transactionsAttemptedLastYear;
    }

    /**
     * Number of purchases with this shopper account during the previous six months.
     * @return null|int
     */
    public function getPurchasesCompletedLastSixMonths()
    {
        $this->protectGet('purchasesCompletedLastSixMonths');
        return $this->purchasesCompletedLastSixMonths;
    }

    /**
     * Number of purchases with this shopper account during the previous six months.
     * @param int $purchasesCompletedLastSixMonths
     */
    public function setPurchasesCompletedLastSixMonths(int $purchasesCompletedLastSixMonths)
    {
        $this->setItem('purchasesCompletedLastSixMonths');
        $this->purchasesCompletedLastSixMonths = $purchasesCompletedLastSixMonths;
    }

    /**
     * Number of Add Card attempts in the last 24 hours.
     * @return null|int
     */
    public function getAddCardAttemptsLastDay()
    {
        $this->protectGet('addCardAttemptsLastDay');
        return $this->addCardAttemptsLastDay;
    }

    /**
     * Number of Add Card attempts in the last 24 hours.
     * @param int $addCardAttemptsLastDay
     */
    public function setAddCardAttemptsLastDay(int $addCardAttemptsLastDay)
    {
        $this->setItem('addCardAttemptsLastDay');
        $this->addCardAttemptsLastDay = $addCardAttemptsLastDay;
    }

    /**
     * Indicates whether the merchant has experienced suspicious activity (including previous fraud) on the shopper account.
     * @return null|bool
     */
    public function getPreviousSuspiciousActivity()
    {
        $this->protectGet('previousSuspiciousActivity');
        return $this->previousSuspiciousActivity;
    }

    /**
     * Indicates whether the merchant has experienced suspicious activity (including previous fraud) on the shopper account.
     * @param bool $previousSuspiciousActivity
     */
    public function setPreviousSuspiciousActivity(bool $previousSuspiciousActivity)
    {
        $this->setItem('previousSuspiciousActivity');
        $this->previousSuspiciousActivity = $previousSuspiciousActivity;
    }

    /**
     * Indicates if the cardholder name on the account is identical to the shipping name used for this transaction.
     * @return null|bool
     */
    public function getShippingNameMatchesAccountName()
    {
        $this->protectGet('shippingNameMatchesAccountName');
        return $this->shippingNameMatchesAccountName;
    }

    /**
     * Indicates if the cardholder name on the account is identical to the shipping name used for this transaction.
     * @param bool $shippingNameMatchesAccountName
     */
    public function setShippingNameMatchesAccountName(bool $shippingNameMatchesAccountName)
    {
        $this->setItem('shippingNameMatchesAccountName');
        $this->shippingNameMatchesAccountName = $shippingNameMatchesAccountName;
    }

    /**
     * Indicates how long the shopper had the account with the merchant.
     * @return null|string 
     */
    public function getShopperAccountAgeIndicator()
    {
        $this->protectGet('shopperAccountAgeIndicator');
        return $this->shopperAccountAgeIndicator;
    }

    /**
     * Indicates how long the shopper had the account with the merchant.
     * One of the ShopperAccountRiskData::SHOPPER_ACCOUNT_AGE_INDICATOR_ constants
     * @param string $shopperAccountAgeIndicator
     */
    public function setShopperAccountAgeIndicator(string $shopperAccountAgeIndicator)
    {
        $this->setItem('shopperAccountAgeIndicator');
        $this->shopperAccountAgeIndicator = $shopperAccountAgeIndicator;
    }

    /**
     * Length of time since the last change to the shopper's account. This includes billing or shipping address, new payment methods or new users added.
     * @return null|string
     */
    public function getShopperAccountChangeIndicator()
    {
        $this->protectGet('shopperAccountChangeIndicator');
        return $this->shopperAccountChangeIndicator;
    }

    /**
     * Length of time since the last change to the shopper's account. This includes billing or shipping address, new payment methods or new users added.
     * One of the ShopperAccountRiskData::SHOPPER_ACCOUNT_CHANGE_INDICATOR_ constants
     * @param string $shopperAccountChangeIndicator
     */
    public function setShopperAccountChangeIndicator(string $shopperAccountChangeIndicator)
    {
        $this->setItem('shopperAccountChangeIndicator');
        $this->shopperAccountChangeIndicator = $shopperAccountChangeIndicator;
    }

    /**
     * Indicates when the shopper's account password was last changed or reset.
     * @return null|string
     */
    public function getShopperAccountPasswordChangeIndicator()
    {
        $this->protectGet('shopperAccountPasswordChangeIndicator');
        return $this->shopperAccountPasswordChangeIndicator;
    }

    /**
     * Indicates when the shopper's account password was last changed or reset.
     * One of the ShopperAccountRiskData::SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_ constants
     * @param string $shopperAccountPasswordChangeIndicator
     */
    public function setShopperAccountPasswordChangeIndicator(string $shopperAccountPasswordChangeIndicator)
    {
        $this->setItem('shopperAccountPasswordChangeIndicator');
        $this->shopperAccountPasswordChangeIndicator = $shopperAccountPasswordChangeIndicator;
    }

    /**
     * Indicates when the shipping address was first used.
     * @return null|string
     */
    public function getShopperAccountShippingAddressUsageIndicator()
    {
        $this->protectGet('shopperAccountShippingAddressUsageIndicator');
        return $this->shopperAccountShippingAddressUsageIndicator;
    }

    /**
     * Indicates when the shipping address was first used.
     * One of the ShopperAccountRiskData::SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_ constants
     * @param string $shopperAccountShippingAddressUsageIndicator
     */
    public function setShopperAccountShippingAddressUsageIndicator(string $shopperAccountShippingAddressUsageIndicator)
    {
        $this->setItem('shopperAccountShippingAddressUsageIndicator');
        $this->shopperAccountShippingAddressUsageIndicator = $shopperAccountShippingAddressUsageIndicator;
    }

    /**
     * Indicates when the payment account was first used.
     * @return null|string
     */
    public function getShopperAccountPaymentAccountIndicator()
    {
        $this->protectGet('shopperAccountPaymentAccountIndicator');
        return $this->shopperAccountPaymentAccountIndicator;
    }

    /**
     * Indicates when the payment account was first used.
     * One of the ShopperAccountRiskData::SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_ constants
     * @param string $shopperAccountPaymentAccountIndicator
     */
    public function setShopperAccountPaymentAccountIndicator(string $shopperAccountPaymentAccountIndicator)
    {
        $this->setItem('shopperAccountPaymentAccountIndicator');
        $this->shopperAccountPaymentAccountIndicator = $shopperAccountPaymentAccountIndicator;
    }
}