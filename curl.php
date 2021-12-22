<?php

class curl
{ 
    function get($url) {
         
        $cURL_Connection = curl_init($url);
        curl_setopt($cURL_Connection, CURLOPT_RETURNTRANSFER, true);
        $cURL_Input = curl_exec($cURL_Connection);
        curl_close($cURL_Connection);
        return (json_decode($cURL_Input,true));
   }
}

