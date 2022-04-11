<?php

namespace QRTips\WooCommerce\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails as MultiSafepayCustomerDetails;

class CustomerDetails
{

    /**
     * @param array $customerData
     * @return MultiSafepayCustomerDetails
     */
    public function create(array $customerData): MultiSafepayCustomerDetails
    {
        return (new MultiSafepayCustomerDetails())
            ->addFirstName($customerData['firstname'])
            ->addLastName($customerData['lastname'])
            ->addEmailAddressAsString($customerData['email'])
            ->addPhoneNumberAsString($customerData['tel'])
            ->addAddress((new Address())->create($customerData));
    }
}