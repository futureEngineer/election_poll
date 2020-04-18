<?php
/*

- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.

*/

if($_SERVER['HTTP_HOST'] == 'krishnafortoday.com'){
    $environment = 'PROD';
    $merchantKey = '';
    $merchantId = '';
    $website = 'WEBPROD';
    $industryTypeId = 'Retail';
} else{
    $environment = 'TEST';
    $merchantKey = '';
    $merchantId = '';
    $website = 'WEBSTAGING';
    $industryTypeId = 'Retail';
}

define('PAYTM_ENVIRONMENT', "$environment");
define('PAYTM_MERCHANT_KEY', "$merchantKey");
define('PAYTM_MERCHANT_MID', "$merchantId");
define('PAYTM_MERCHANT_WEBSITE', "$website");
define('PAYTM_INDUSTRY_TYPE_ID', "$industryTypeId");

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


