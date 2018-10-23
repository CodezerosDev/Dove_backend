<?php

/**
 * Created by Chirag Ardeshna.
 * User: Chirag Ardeshna
 * Date: 3/23/2015
 * Time: 4:20 PM
 * version: 0.1
 */
class MY_Input extends CI_Input
{

    public function __construct()
    {
        parent::__construct();
    }

    function all($xss_clean = FALSE)
    {
        $get = $this->get(NULL, $xss_clean);
        $post = $this->post(NULL, $xss_clean);
        if ($get == false) {
            $get = array();
        }
        if ($post == false) {
            $post = array();
        }
        return array_merge($post, $get);
    }
}