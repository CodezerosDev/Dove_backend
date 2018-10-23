<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('deduct_datetime_diff'))
{
    function my_datetime_diff($req_datetime,$diff='0')
    {
        list($h, $m, $s) = explode(':', $diff);
        $time = ($h * 3600) + ($m * 60) + $s;

        $newDateTime = date("m/d/Y h:i A",strtotime($req_datetime) + $time);
        return $newDateTime;
    }
}

?>