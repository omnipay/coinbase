<?php

namespace Omnipay\Coinbase\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Coinbase Purchase Response
 */
class PurchaseResponse extends Response implements RedirectResponseInterface
{
    protected $redirectLiveEndpoint = 'https://api.coinbase.com/v2/checkouts';
    protected $redirectTestEndpoint = 'https://api.sandbox.coinbase.com/v2/checkouts';

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
            return $this->redirectEndpoint.'/'.$this->getTransactionReference();
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
    
    protected function getCheckoutEndpoint()
    {
        return $this->getRequest()->getTestMode() ? $this->redirectTestEndpoint : $this->redirectLiveEndpoint;
    }
}
