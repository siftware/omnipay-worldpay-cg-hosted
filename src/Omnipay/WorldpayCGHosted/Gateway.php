<?php

namespace Omnipay\WorldpayCGHosted;

use Omnipay\Common\AbstractGateway;
use Omnipay\WorldpayCGHosted\Message\Notification;

/**
 * WorldPay Hosted Corporate Gateway (XML)
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'WorldpayCGHosted';
    }

    /**
     * Get default parameters
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'installation' => '',
            'merchant'     => '',
            'password'     => '',
            'testMode'     => false,
        ];
    }

    /**
     * Get accept header
     *
     * @return string
     */
    public function getAcceptHeader()
    {
        return $this->getParameter('acceptHeader');
    }

    /**
     * Set accept header
     *
     * @param string $value Accept header value
     *
     * @return Gateway
     */
    public function setAcceptHeader($value)
    {
        return $this->setParameter('acceptHeader', $value);
    }

    /**
     * Get installation
     *
     * @return string
     */
    public function getInstallation()
    {
        return $this->getParameter('installation');
    }

    /**
     * Set installation
     *
     * @param string $value Installation value
     *
     * @return Gateway
     */
    public function setInstallation($value)
    {
        return $this->setParameter('installation', $value);
    }

    /**
     * Get merchant
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->getParameter('merchant');
    }

    /**
     * Set merchant
     *
     * @param string $value Merchant value
     *
     * @return Gateway
     */
    public function setMerchant($value)
    {
        return $this->setParameter('merchant', $value);
    }

    /**
     * Get pa response
     *
     * @return string
     */
    public function getPaResponse()
    {
        return $this->getParameter('pa_response');
    }

    /**
     * Set pa response
     *
     * @param string $value Pa response value
     *
     * @return Gateway
     */
    public function setPaResponse($value)
    {
        return $this->setParameter('pa_response', $value);
    }

    /**
     * Get the separate username if configured (more secure approach for basic auth) or fallback to merchant if not
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->parameters->get('username', $this->getParameter('merchant'));
    }

    /**
     * Set basic auth username
     *
     * @param string $value
     * @return Gateway
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set password
     *
     * @param string $value Password value
     *
     * @return Gateway
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->getParameter('session');
    }

    /**
     * Set session
     *
     * @param string $value Session value
     *
     * @return Gateway
     */
    public function setSession($value)
    {
        return $this->setParameter('session', $value);
    }

    /**
     * Get user agent header
     *
     * @return string
     */
    public function getUserAgentHeader()
    {
        return $this->getParameter('userAgentHeader');
    }

    /**
     * Set user agent header
     *
     * @param string $value User agent header value
     *
     * @return Gateway
     */
    public function setUserAgentHeader($value)
    {
        return $this->setParameter('userAgentHeader', $value);
    }

    /**
     * Get user ip
     *
     * @return string
     */
    public function getUserIP()
    {
        return $this->getParameter('userIP');
    }

    /**
     * Set user ip
     *
     * @param string $value User ip value
     *
     * @return Gateway
     */
    public function setUserIP($value)
    {
        return $this->setParameter('userIP', $value);
    }

    /**
     * Purchase
     *
     * @param array $parameters Parameters
     *
     * @return \Omnipay\WorldpayCGHosted\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(
            Message\PurchaseRequest::class,
            $parameters
        );
    }

    public function acceptNotification(array $options = array()): \Omnipay\Common\Message\NotificationInterface
    {
        $data = $this->httpRequest->getContent();
        $this->quickLog($_SERVER, "a", 'wpg-notification');
        $this->quickLog($data, "a", 'wpg-notification');


        $notification = new Notification($data, $this->httpRequest->getClientIp());

        if (($options['disable_ip_checks'] ?? false) === true) {
            $notification->setAllowIpBasedOriginCheck(false);
        }
        if (($options['disable_hostname_checks'] ?? false) === true) {
            $notification->setAllowHostnameBasedOriginCheck(false);
        }

        return $notification;
    }

    function	quickLog($debugData,$mode = "w",$file = false){
        //print_r whatever is passed to a log file

        $data	= 	print_r($debugData,true);

        if (!$file){
            $file 	= 	STORAGE_DIRECTORY . "/logs/quickLog.txt";
        }
        else {
            $file = 		STORAGE_DIRECTORY . "/logs/".$file;
        }

        $res	=	fopen($file,$mode);

        if		(	fwrite($res,$data)	){
            $close	=	fclose($res);
            return true;
        }
        else 	{
            $close	=	fclose($res);
            return false;
        }
    }
}
