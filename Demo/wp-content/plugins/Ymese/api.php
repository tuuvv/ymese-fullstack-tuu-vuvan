<?php

function postdemo($text) {

$url = "http://api.test/index.php/api/exportpdf";



    $postdata = '{"text": '.$text.'}';

    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    
    // Check the return value of curl_exec(), too
    if ($result === false) {
     echo curl_error($ch);
    }
    curl_close($ch);
    $result = json_decode($result, true);
    // var_dump($result);
// die();
    return $result;



}