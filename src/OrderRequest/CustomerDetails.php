<?php

namespace QRTips\WooCommerce\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails as MultiSafepayCustomerDetails;

class CustomerDetails {

    /**
     * @param array $customerAddress
     * @return MultiSafepayCustomerDetails
     */
    public function create(array $customerAddress): MultiSafepayCustomerDetails
    {
        return (new MultiSafepayCustomerDetails())
            ->addFirstName("Robin")
            ->addLastName("de Laater")
            ->addEmailAddressAsString("robin@test.com")
            ->addAddress((new Address())->create($customerAddress));
    }
}