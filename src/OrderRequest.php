<?php

namespace QRTips\WooCommerce;

use MultiSafepay\Api\Transactions\OrderRequest as MultiSafepayOrderRequest;
use MultiSafepay\ValueObject\Money;
use QRTips\WooCommerce\OrderRequest\CustomerDetails;

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
     * @param array $customerData
     *
     * @return MultiSafepayOrderRequest
     */
    public function create(array $customerData): MultiSafepayOrderRequest
    {
        return (new MultiSafepayOrderRequest())
            ->addType('redirect')
            ->addOrderId($this->orderId)
            ->addDescriptionText($this->description)
            ->addCustomer((new CustomerDetails())->create($customerData))
            ->addMoney($this->amount)
            ->addPluginDetails((new OrderRequest\PluginDetails())->create());
    }
}