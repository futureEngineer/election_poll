<?php
date_default_timezone_set("Asia/Calcutta");
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
include('httpful.phar');
$start_time =Date("Y-m-d H:i:s");
$start_time."\n";
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
    $http = "https://";
} else {
    $http = "http://";
}

// prescription completed remainder to patient.

$url=  $http.$_SERVER['HTTP_HOST'].'/';

    $uri_login = $url.'kft/api/index.php/v1/cron/sample';
       $result_login = \Httpful\Request::get($uri_login)
                            ->sendsJson()
                            ->addHeader("Content-Type", "application/json")
                            ->send();


print_r($result_login);
?>
