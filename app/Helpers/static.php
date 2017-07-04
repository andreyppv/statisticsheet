<?php

if ( ! function_exists('report_fields')) {
    function report_fields($includeTotal = true)
    {
        $result = array();
        for($m=1; $m<=12; ++$m){
            $v = date('M', mktime(0, 0, 0, $m, 1));
            $result[strtolower($v)] = $v;
        }

        if($includeTotal) {
            $result['total'] = 'Total';
            $result['avg'] = 'Avg';
        }

        return $result;
    }
}