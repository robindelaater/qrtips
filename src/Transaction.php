<?php

namespace QRTips\WooCommerce;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Sdk;
use MultiSafepay\ValueObject\Money;

class Transaction
{
  public const API_KEY = '6e782b6c9747acd10abc3b4babd0f30fe656769a';
  public const PRODUCTION = false;

  private Sdk $sdk;
  private string $orderId;
  private string $description;
  private Money $amount;

  public function __construct(int $amount)
  {
    $this->sdk = new Sdk(self::API_KEY, self::PRODUCTION);
    $this->orderId = (string) time();
    $this->description = 'QR Tip #' . $this->orderId;
    $this->amount = new Money($amount);
  }

  public function getPluginDetails(): PluginDetails
  {
    $pluginDetails = new PluginDetails();
    $pluginDetails->addPluginVersion('0.0.1');
    $pluginDetails->addApplicationName('QR Tips');
    $pluginDetails->addApplicationVersion('QR Tips Plugin');

    return $pluginDetails;
  }

  public function getOrderRequest(): OrderRequest
  {
    $orderRequest = new OrderRequest();
    $orderRequest->addType('redirect');
    $orderRequest->addOrderId($this->orderId);
    $orderRequest->addDescriptionText($this->description);
    $orderRequest->addMoney($this->amount);
    $orderRequest->addPluginDetails($this->getPluginDetails());

    return $orderRequest;
  }

  public function createTransaction(): string
  {
    /** @var TransactionResponse $transaction */
    $transactionManager = $this->sdk->getTransactionManager()->create($this->getOrderRequest());
    return $transactionManager->getPaymentUrl();
  }
}