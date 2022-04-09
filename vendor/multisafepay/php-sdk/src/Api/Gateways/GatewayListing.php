<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

class GatewayListing
{
    /** @var array */
    private $gateways;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $gateways = [];
        if (!empty($data)) {
            foreach ($data as $gatewayData) {
                $gateways[] = new Gateway($gatewayData);
            }
        }
        $this->gateways = $gateways;
    }

    /**
     * @return Gateway[]
     */
    public function getGateways(): array
    {
        return $this->gateways;
    }
}
