<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

/*
 * Created Date : 09/07/2013 (mm/dd/yyyy)
 * Author       : Nakkeeran.k
 */

//Util methods

class Util {

    function __construct() {
        
    }

    function get_rand($length, $possible = "0123456789abcdefghijklmnopqrstuvwxyz") {
        srand((double) microtime() * 1000000);
        $str = "";
        while (strlen($str) < $length) {
            $str .= substr($possible, rand(0, 50), 1);
        }
        return($str);
    }

    function get_extension($filename) {
        $x = explode('.', $filename);
        return '.' . end($x);
    }

    function is_allowed_filetype($ext) {
        $ext = strtolower(ltrim($ext, '.'));
        $image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');
        if (!in_array($ext, $image_types)) {
            return false;
        }
        return true;
    }

    function is_allowed_filesize($filesize) {
        if ($filesize > (5 * 1024 * 1024)) {
            return false;
        }
        return true;
    }

    function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }

    /* Date */

    function convertdate($d) {
        return "STR_TO_DATE('{$d}','%d/%m/%Y')";
    }

    //http://www.rarst.net/script/php-date-range/
    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d') {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);
        while ($current <= $last) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    /* End Date */

    //http://stackoverflow.com/questions/2440506/how-to-check-if-an-array-value-exists
    function searcharray($needle, $haystack) {
        if (in_array($needle, $haystack)) {
            return true;
        }
        foreach ($haystack as $element) {
            if (is_array($element) && $this->searcharray($needle, $element))
                return true;
        }
        return false;
    }

    function age($date) {
       // return date_diff(date_create($date), date_create('today'))->y;
       return floor((time() - strtotime($date)) / 31556926);        
    }

    //http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
    function gen_uuid() {
        $s_udid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        //so maximun return 50 char length...
        return substr($s_udid, 0, 50);
    }
    
    //http://stackoverflow.com/questions/15153776/convert-base64-string-to-an-image-file
    function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);

        return $output_file;
    }
    
    //Aws full file url 
    function aws_file_url($bucket_name , $target_path ){
        return "https://".$bucket_name.".s3.amazonaws.com/".$target_path;
    }

}

?>