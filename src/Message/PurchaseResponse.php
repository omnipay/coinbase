<?php

namespace Omnipay\Coinbase\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Coinbase Purchase Response
 */
class PurchaseResponse extends Response implements RedirectResponseInterface
{
    protected $liveRedirectEndpoint = 'https://coinbase.com/checkouts';
    protected $testRedirectEndpoint = 'https://sandbox.coinbase.com/checkouts';

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return isset($this->data['success']) && $this->data['success'];
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->getRedirectEndpoint().'/'.$this->getTransactionReference();
        }
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['button']['code'])) {
            return $this->data['button']['code'];
        }
    }

    public function getRedirectEndpoint()
    {
        return $this->getTestMode() ? $this->testRedirectEndpoint : $this->liveRedirectEndpoint;
    }
}
