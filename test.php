<?php

// $xml = new DOMDocument();
// $xml->load('https://webservice.ilpen.com.tr/xml/xml_ideasoft_all_products');
header("Content-Type: text/html; charset=utf8");


//Veri Çekiliyor
//$veri = simplexml_load_file("https://webservice.ilpen.com.tr/xml/xml_ideasoft_all_products", "SimpleXMLElement", LIBXML_NOCDATA);
 $veri = simplexml_load_file("./xml_ideasoft_all_products.xml");
// $json = json_encode($xml);
// $array = json_decode($json, TRUE);
// var_dump($array);
 
//$array = json_decode(json_encode((array)simplexml_load_string("./xml_ideasoft_all_products.xml")),true);
 
$xml_array=object2array($veri);
echo "<pre>";
var_dump($xml_array["item"][110]);
echo "</pre>";
function object2array($object) { return @json_decode(@json_encode($object),1); }
