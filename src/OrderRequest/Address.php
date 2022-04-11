<?php

namespace QRTips\WooCommerce\OrderRequest;

use MultiSafepay\ValueObject\Customer\Address as MultiSafepayAddress;

class Address
{
    public function create(array $customerData): MultiSafepayAddress
    {
        return (new MultiSafepayAddress())
            ->addStreetName($customerData['streetname'])
            ->addHouseNumber($customerData['housenumber'])
            ->addCity($customerData['city'])
            ->addZipCode($customerData['zipcode'])
            ->addCountryCode($customerData['country']);
    }
}