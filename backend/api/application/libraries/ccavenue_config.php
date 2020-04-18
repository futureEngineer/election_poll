<?php
if($_SERVER['HTTP_HOST'] == 'krishnafortoday.com'){
    $environment = 'PROD';
    $accessCode = 'AVDW74EK16AP48WDPA';
    $workingKey = 'B0A0369224C2D5E128A57A0B7AD11D1A';
    $merchantId = '105932';
   // $CCAVENUE_PAYMENT_URL='    https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
} else if($_SERVER['HTTP_HOST'] == 'ramkeshav.com'){
    $environment = 'TEST';
    $accessCode = 'AVWM03HB05AM64MWMA';
    $workingKey = '5489D40CB2AC4711BB81AD07A921DBCE';
    $merchantId = '105932';
    //$CCAVENUE_PAYMENT_URL='    https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
} else {
    $environment = 'TEST';
    $accessCode = 'AVXV89GK08CK65VXKC';
    $workingKey = '88E2BE56784713E1C03568A3C2C1D2ED';
    $merchantId = '105932';

}
//$CCAVENUE_PAYMENT_URL='https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
$CCAVENUE_PAYMENT_URL='https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
define('CCAVENUE_ENVIRONMENT', "$environment");
define('CCAVENUE_MERCHANT_ID', "$merchantId");
define('CCAVENUE_ACCESS_CODE', "$accessCode");
define('CCAVENUE_WORKING_KEY', "$workingKey");
define('CCAVENUE_PAYMENT_URL', "$CCAVENUE_PAYMENT_URL");
?>