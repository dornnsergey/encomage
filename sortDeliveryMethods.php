<?php

declare(strict_types=1);

$deliveryMethodsArray = [
    [
        'code' => 'dhl',
        'customer_costs' => [
            22 => '1.000',
            11 => '3.000',
        ]
    ],
    [
        'code' => 'fedex',
        'customer_costs' => [
            22 => '4.000',
            11 => '6.000',
        ]
    ]
];

/*array(2) {
    [22]=>
  array(2) {
        ["dhl"]=>
    string(5) "1.000"
        ["fedex"]=>
    string(5) "4.000"
  }
  [11]=>
  array(2) {
        ["dhl"]=>
    string(5) "3.000"
        ["fedex"]=>
    string(5) "6.000"
  }
}*/

function sortDeliveryMethods(array $deliveryMethods): array
{
    $result = [];

    foreach ($deliveryMethods as $deliveryMethod) {
        foreach ($deliveryMethod['customer_costs'] as $customer => $cost) {
            $result[$customer][$deliveryMethod['code']] = $cost;
        }
    }

    return $result;
}


$result = sortDeliveryMethods($deliveryMethodsArray);

var_dump($result);