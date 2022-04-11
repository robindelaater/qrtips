<?php

namespace QRTips\WooCommerce;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Sdk;
use Psr\Http\Client\ClientExceptionInterface;

class Transaction
{
    private string $apiKey;
    private bool $isProduction;
    private Sdk $sdk;
    private OrderRequest $orderRequest;

    public function __construct(string $apiKey, bool $isProduction, OrderRequest $orderRequest)
    {
        $this->apiKey = $apiKey;
        $this->isProduction = $isProduction;
        $this->sdk = new Sdk($this->apiKey, $this->isProduction);
        $this->orderRequest = $orderRequest;
    }

    public function create(): string
    {
        /** @var TransactionResponse $transaction */
        try {
            $transactionManager = $this->sdk->getTransactionManager()->create($this->orderRequest);
            return $transactionManager->getPaymentUrl();
        } catch (ClientExceptionInterface $e) {
            (new \WP_Error())->add($e->getCode(), $e->getMessage());
            return "";
        }
    }
}