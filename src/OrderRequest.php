<?php

namespace QRTips\WooCommerce;

use MultiSafepay\Api\Transactions\OrderRequest as MultiSafepayOrderRequest;
use MultiSafepay\ValueObject\Money;

class OrderRequest {

    private string $orderId;
    private string $description;
    private Money $amount;

    /**
     * Constructor bla bla bla
     *
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->orderId = 'QR'.time();
        $this->description = get_bloginfo('name') . ' QR Tip: ' . $this->orderId;
        $this->amount = new Money($amount);
    }

    /**
     * @return MultiSafepayOrderRequest
     */
    public function create(): MultiSafepayOrderRequest
    {
        return (new MultiSafepayOrderRequest())
            ->addType('redirect')
            ->addOrderId($this->orderId)
            ->addDescriptionText($this->description)
            ->addMoney($this->amount)
            ->addPluginDetails((new OrderRequest\PluginDetails())->create());
    }
}