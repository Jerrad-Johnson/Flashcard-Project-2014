<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 11/19/2014
 * Time: 10:12 PM
 */

function jsonResponse($response, $data){

    if (gettype($response) == "array") {
        $arr = array();
        $i = "0";
        foreach ($response as $title) {
            $arr[$title] = $data[$i];
            $i++;
        }
        $arr = json_encode($arr);
        return $arr;
    } else {
        $arr = [$response => $data];
        $arr = json_encode($arr);
        return $arr;
    }
}

?>
