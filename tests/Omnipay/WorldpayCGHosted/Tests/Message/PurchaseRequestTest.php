<?php

namespace Omnipay\WorldpayCGHosted\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;
use Omnipay\WorldpayCGHosted\AuthenticationRiskData;
use Omnipay\WorldpayCGHosted\Message\PurchaseRequest;
use Omnipay\WorldpayCGHosted\ShopperAccountRiskData;
use Omnipay\WorldpayCGHosted\TransactionRiskData;

class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $purchase;

    public function setUp()
    {
        parent::setUp();

        $this->purchase = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->purchase->setAmount(7.45);
        $this->purchase->setCurrency('GBP');
        $this->purchase->setCard(new CreditCard([
            'billingFirstName' => 'Vince',
            'billingLastName' => 'Staples',
            'shippingFirstName' => 'Vince',
            'shippingLastName' => 'Staples',
            'email' => 'cr+vs@noellh.com',
            'billingAddress1' => '745 THORNBURY CLOSE',
            'shippingAddress1' => '745 THORNBURY CLOSE',
            'billingAddress2' => '',
            'shippingAddress2' => '',
            'billingCity' => 'LONDON',
            'shippingCity' => 'LONDON',
            'billingCountry' => 'GB',
            'shippingCountry' => 'GB',
            'billingPostcode' => 'N16 8UX',
            'shippingPostcode' => 'N16 8UX',
        ]));
        $this->purchase->setAuthenticationRiskData(new AuthenticationRiskData(
            [                
                'authenticationTimestamp' => new \DateTime('now'),
                'authenticationMethod' => AuthenticationRiskData::AUTHENTICATION_METHOD_LOCAL_ACCOUNT,
            ]
        ));
        $this->purchase->setShopperAccountRiskData(new ShopperAccountRiskData([
                'shopperAccountCreationDate' => new \DateTime('now'),
                'shopperAccountModificationDate' => new \DateTime('now'),
                'shopperAccountPasswordChangeDate' => new \DateTime('now'),
                'shopperAccountShippingAddressFirstUseDate' => new \DateTime('now'),
                'shopperAccountPaymentAccountFirstUseDate' => new \DateTime('now'),
                'transactionsAttemptedLastDay' => 2,
                'transactionsAttemptedLastYear' => 10,
                'purchasesCompletedLastSixMonths' => 3,
                'addCardAttemptsLastDay' => 1,
                'previousSuspiciousActivity' => false,
                'shippingNameMatchesAccountName' => true,
                'shopperAccountAgeIndicator' => ShopperAccountRiskData::SHOPPER_ACCOUNT_AGE_INDICATOR_MORE_THAN_SIXTY_DAYS,
                'shopperAccountChangeIndicator' => ShopperAccountRiskData::SHOPPER_ACCOUNT_CHANGE_INDICATOR_MORE_THAN_SIXTY_DAYS,
                'shopperAccountPasswordChangeIndicator' => ShopperAccountRiskData::SHOPPER_ACCOUNT_PASSWORD_CHANGE_INDICATOR_NO_CHANGE,
                'shopperAccountShippingAddressUsageIndicator' => ShopperAccountRiskData::SHOPPER_ACCOUNT_SHIPPING_ADDRESS_USAGE_INDICATOR_MORE_THAN_SIXTY_DAYS,
                'shopperAccountPaymentAccountIndicator' => ShopperAccountRiskData::SHOPPER_ACCOUNT_PAYMENT_ACCOUNT_INDICATOR_MORE_THAN_SIXTY_DAYS,
        ]));
        $this->purchase->setTransactionRiskData(new TransactionRiskData([
            'transactionRiskDataGiftCardAmount' => 34,
            'transactionRiskDataPreOrderDate' => new \DateTime('now'),
            'shippingMethod' => TransactionRiskData::SHIPPING_METHOD_SHIP_TO_STORE,
            'deliveryTimeframe' => TransactionRiskData::DELIVERY_TIMEFRAME_OVERNIGHT_SHIPPING,
            'deliveryEmailAddress' => 'test@email.local',
            'reorderingPreviousPurchases' => false,
            'preOrderPurchase' => false,
            'giftCardCount' => 1,
        ]));
    }

    public function testAmountDetails()
    {
        $data = $this->purchase->getData();
        $this->assertEquals('745', $data->submit->order->amount->attributes()['value']);
        $this->assertEquals('GBP', $data->submit->order->amount->attributes()['currencyCode']);
        $this->assertEquals('2', $data->submit->order->amount->attributes()['exponent']);

        // Not included in a normal purchase request's data
        $this->assertEmpty($data->submit->order->session);
    }

    public function testDefaultDescription()
    {
        $data = $this->purchase->getData();
        $this->assertEquals('Merchandise', $data->submit->order->description);
    }

    public function testPaymentMethodMaskWithKnownOmnipayType()
    {
        $this->purchase->setPaymentType('mAstErcARd'); // gets lowercased for array key
        $data = $this->purchase->getData();
        $this->assertEquals('ECMC-SSL', $data->submit->order->paymentMethodMask->include->attributes()['code']);
    }

    public function testPaymentMethodMaskWithKnownWorldpayTypeThatAlsoHasOmnipayType()
    {
        $this->purchase->setPaymentType('MSCD');
        $data = $this->purchase->getData();
        $this->assertEquals('ECMC-SSL', $data->submit->order->paymentMethodMask->include->attributes()['code']);
    }

    public function testPaymentMethodMaskWithKnownWorldpayTypeAndNoOmnipayType()
    {
        $this->purchase->setPaymentType('VIED'); // Visa Electron
        $data = $this->purchase->getData();
        $this->assertEquals('VISA-SSL', $data->submit->order->paymentMethodMask->include->attributes()['code']);
    }

    public function testPaymentMethodMaskWithKnownWorldpaySSLKeyAndNoOnipayType()
    {
        $this->purchase->setPaymentType('ECMC');
        $data = $this->purchase->getData();
        $this->assertEquals('ECMC-SSL', $data->submit->order->paymentMethodMask->include->attributes()['code']);
    }

    /**
     * For a type we don't know about, we should not apply a payment type mask, i.e. 'ALL' are shown
     */
    public function testPaymentMethodMaskWithUnknownType()
    {
        $this->purchase->setPaymentType('Bitcoin');
        $data = $this->purchase->getData();
        $this->assertEquals('ALL', $data->submit->order->paymentMethodMask->include->attributes()['code']);
    }

    public function testCustomDescription()
    {
        $this->purchase->setDescription('Goods n services');
        $data = $this->purchase->getData();
        $this->assertEquals('Goods n services', $data->submit->order->description);
    }

    public function testAddressInNormalCase()
    {
        $data = $this->purchase->getData();
        $this->assertEquals('745 THORNBURY CLOSE', (string) $data->submit->order->billingAddress->address->address1);
        $this->assertEquals('LONDON', (string) $data->submit->order->billingAddress->address->city);
        $this->assertEquals('N16 8UX', (string) $data->submit->order->billingAddress->address->postalCode);
        $this->assertEquals('GB', (string) $data->submit->order->billingAddress->address->countryCode);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidCreditCardException
     * @expectedExceptionMessage A billing address is required for this transaction
     */
    public function testAddressMissingWhenRequired()
    {
        $this->purchase->setCard(new CreditCard(['email' => 'cr+vs@noellh.com'])); // Remove postal address info
        $this->purchase->getData();
    }

    public function testAddressProvidedButIgnored()
    {
        $this->purchase->setUseBillingAddress(false);
        $data = $this->purchase->getData();

        $this->assertEquals('cr+vs@noellh.com', (string) $data->submit->order->shopper->shopperEmailAddress);
        $this->assertEquals(0, $data->submit->order->billingAddress->count());
    }

    public function testAddressMissingAndIgnored()
    {
        $this->purchase->setUseBillingAddress(false);
        $this->purchase->setCard(new CreditCard(['email' => 'cr+vs@noellh.com'])); // Remove postal address info
        $data = $this->purchase->getData();

        $this->assertEquals('cr+vs@noellh.com', (string) $data->submit->order->shopper->shopperEmailAddress);
        $this->assertEquals(0, $data->submit->order->billingAddress->count());
    }

    /**
     * This has not been tested against a real implementation, and may not be relevant for the Hosted gateway?
     * However this test covers the properties I'd expect to see from reading the wider XML API's docs.
     */
    public function test3DSecureResponse()
    {
        $this->purchase->setPaResponse('Some PA value');
        $this->purchase->setSession('vinces-session-token');
        $this->purchase->setClientIp('10.0.7.45');

        $data = $this->purchase->getData();

        $this->assertEquals('10.0.7.45', $data->submit->order->session->attributes()['shopperIPAddress']);
        $this->assertEquals('vinces-session-token', $data->submit->order->session->attributes()['id']);
        $this->assertEquals('Some PA value', $data->submit->order->info3DSecure->paResponse);
    }

    public function testAuxiliarySettersAndGetters()
    {
        $this->assertNull($this->purchase->getAcceptHeader());
        $this->assertNull($this->purchase->getPaResponse());
        $this->assertNull($this->purchase->getSession());
        $this->assertNull($this->purchase->getUserAgentHeader());

        $this->purchase->setAcceptHeader('text/xml');
        $this->purchase->setPaResponse('Some value');
        $this->purchase->setSession('my-token-key');
        $this->purchase->setUserAgentHeader('My great browser');

        $this->assertEquals('text/xml', $this->purchase->getAcceptHeader());
        $this->assertEquals('Some value', $this->purchase->getPaResponse());
        $this->assertEquals('my-token-key', $this->purchase->getSession());
        $this->assertEquals('My great browser', $this->purchase->getUserAgentHeader());
    }

    public function testGetEndpointProductionMode()
    {
        $getEndpoint = self::getMethod('getEndpoint');
        $purchase = clone $this->purchase;

        $purchase->setTestMode(true);
        $testEndpoint = $getEndpoint->invokeArgs($purchase, []);
        $this->assertEquals('https://secure-test.worldpay.com/jsp/merchant/xml/paymentService.jsp', $testEndpoint);

        $purchase->setTestMode(false);
        $liveEndpoint = $getEndpoint->invokeArgs($purchase, []);
        $this->assertEquals('https://secure.worldpay.com/jsp/merchant/xml/paymentService.jsp', $liveEndpoint);
    }
    
    public function testOptionalDataOnlySupportedParameters()
    {
        $this->expectException(\InvalidArgumentException::class);
        new AuthenticationRiskData(
            [
                'authenticationTimestamp' => new \DateTime('now'),
                'authenticationMethod' => AuthenticationRiskData::AUTHENTICATION_METHOD_LOCAL_ACCOUNT,
                'badArgument' => 'badArgument',
            ]
        );
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(PurchaseRequest::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
