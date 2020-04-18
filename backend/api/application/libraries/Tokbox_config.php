<?php

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {

    define('TOKBOX_API_KEY', '46295942');
    define('TOKBOX_SECRET_KEY', 'a588d873cc1b4153c10585f3a630533c341450b0');

} else{
    define('TOKBOX_API_KEY', '46295942');
    define('TOKBOX_SECRET_KEY', 'a588d873cc1b4153c10585f3a630533c341450b0');
}

?>