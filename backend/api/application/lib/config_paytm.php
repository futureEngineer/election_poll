<?php
///*
//
//- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
//- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
//- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
//- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
//- Above details will be different for testing and production environment.
//
if($_SERVER['HTTP_HOST'] == 'krishnafortoday.com') {

    define('PAYTM_ENVIRONMENT', 'PROD'); // TEST
    define('PAYTM_MERCHANT_KEY', ''); //Change this constant's value with Merchant key downloaded from portal
    define('PAYTM_MERCHANT_MID', ''); //Change this constant's value with MID (Merchant ID) received from Paytm
    define('PAYTM_INDUSTRY_TYPE_ID', "");

} else{

    define('PAYTM_ENVIRONMENT', 'TEST'); // TEST
    define('PAYTM_MERCHANT_KEY', ''); //Change this constant's value with Merchant key downloaded from portal
    define('PAYTM_MERCHANT_MID', ''); //Change this constant's value with MID (Merchant ID) received from Paytm
    define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm
    define('PAYTM_INDUSTRY_TYPE_ID', "Retail");
}

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
    $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
    $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}
define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

?>