<?php

if (!function_exists('get_user')) {

    function get_user($id = '') {
        $CI = & get_instance();
        $user = new stdClass();
        $user->id = 0;
        if ($CI->session->userdata('user'))
            $user = $CI->session->userdata('user');
        return $user;
    }

}

function pre($data, $exit = false)
{
    echo "<br />";
    print_r($data);
    if(!$exit)
        die();
}