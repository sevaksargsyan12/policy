<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01.03.2019
 * Time: 18:43
 */

class Helper {
    function filter_option($option,$hasstate = true) {
        if($hasstate)
            $state = '-state';
        return get_option($option . $state) == 'on' ? get_option($option) : false;
    }
    function is_flag( $flag, $atts ) {
        if(!$atts)
            return false;
        foreach ( $atts as $key => $value )
            if ( $value === $flag && is_int( $key ) ) return true;
        return false;
    }
}
$help = new Helper;