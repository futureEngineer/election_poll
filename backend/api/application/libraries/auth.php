<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

class Auth {

    function __construct() {
        
    }

    function is_user_logged() {
        /*  if(!isset($_SESSION["user_id"])){
          return false;
          }
          return true; */
    }

    function get_user_type() {
        /* $susertype = "";
          if (isset($_SESSION["user_type"])) {
          $susertype = $_SESSION["user_type"];
          }
          return $susertype; */
    }

}

?>