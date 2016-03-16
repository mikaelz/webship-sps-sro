<?php

/**
 * Country Codes List
 * http://www.codeofcountry.com/country-codes
 **/
switch ($delivery_country) {
    case 'HU':
        $delivery_country_code = 348;
        break;
    default:
        $delivery_country_code = 703;
}

$params = array(
    'notifytype' => 1,
    'productdesc' => 'Order #'.$order_id,
    'recipientpay' => true,
    'units' => 'kg',
    'packages' => array(
        'reffnr' => $order_id,
        'weight' => 1
    ),
    'pickupaddress' => array(
        'name' => $pickup_name,
        'contactPerson' => $pickup_contact_person,
        'city' => $pickup_city,
        'street' => $pickup_street,
        'zip' => $pickup_zip,
        'country' => $pickup_country,
        'countryshortname' => $pickup_country_code,
        'mobile' => $pickup_mobile,
        'email' => $pickup_email,
    ),
    'deliveryaddress' => array(
        'name' => $delivery_name,
        'contactPerson' => $delivery_contact_person,
        'street' => $delivery_street,
        'city' => $delivery_city,
        'zip' => $delivery_zip,
        'country' => $delivery_country,
        'countryshortname' => $delivery_country_code,
        'mobile' => $delivery_mobile,
        'email' => $delivery_email,
    ),
    'shipmentpickup' => array(
        'pickupstartdatetime' => date('Y-m-d\T09:i:s', strtotime('+1 day')),
        'pickupenddatetime' => date('Y-m-d\T17:i:s', strtotime('+1 day')),
    ),
    'codattribute' => array(
        'codvalue' => $total,
    ),
);

$soap_client = new SoapClient('https://webship.sps-sro.sk/services/WebshipWebService?wsdl');
$soap_response = $soap_client->__soapCall(
    'createShipment',
    array(
        'parameters' => array(
            'name' => LOGIN_NAME,
            'password' => LOGIN_PASSWORD,
            'webServiceShipment' => $params,
            'webServiceShipmentType' => 1,
        )
    )
);

if (isset($soap_response->createShipmentReturn->errors)) {
    echo '<pre>';
    print_r($soap_response);
    echo '</pre>';
    exit;
}
