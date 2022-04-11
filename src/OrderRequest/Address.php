<?php

namespace QRTips\WooCommerce\OrderRequest;

use MultiSafepay\ValueObject\Customer\Address as MultiSafepayAddress;

class Address
{
    public function create(array $customerAddress): MultiSafepayAddress
    {
        return (new MultiSafepayAddress())
            ->addStreetName('test')
            ->addHouseNumber(12)
            ->addCity('12')
            ->addZipCode('12')
            ->addCountryCode('NL');
    }
}