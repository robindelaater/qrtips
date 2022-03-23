<?php

namespace QRTips\WooCommerce;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Sdk;
use MultiSafepay\ValueObject\Money;

class QRTip
{
  private string $apiKey;
  private bool $isProduction;
  private Sdk $sdk;
  private string $orderId;
  private string $description;
  private Money $amount;

  public function __construct(string $apiKey, bool $isProduction, int $amount)
  {
    $this->apiKey = $apiKey;
    $this->isProduction = $isProduction;
    $this->sdk = new Sdk($this->apiKey, $this->isProduction);
    $this->orderId = (string) time();
    $this->description = 'QR Tip #' . $this->orderId . 'at ' . get_bloginfo('name');
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