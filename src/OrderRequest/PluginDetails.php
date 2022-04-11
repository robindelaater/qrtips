<?php

namespace QRTips\WooCommerce\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails as MultiSafepayPluginDetails;

class PluginDetails
{
    /**
     * @return MultiSafepayPluginDetails
     */
    public function create(): MultiSafepayPluginDetails
    {
        return (new MultiSafepayPluginDetails())
            ->addPluginVersion('0.0.1')
            ->addApplicationName('QR Tips')
            ->addApplicationVersion('QR Tips Plugin');
    }
}