<?php
/**
 * Kategoriye baglı tüm ürünleri getireceğimiz servistir.
 */

include_once('./dbSql.php');
$db= new dbSql();

$ids= ($db->getIdAll());
foreach ($ids as $val) {
     $url="https://b2b.ilpen.com.tr/ilpenB2BWebSiteService/jsonapi/list_category_products/?idCategory=".$val;
     $product = get($url); 
     $db->setProduct($val, $product[2]);
}

function get($url) {
     $cURL_Connection = curl_init($url);
     curl_setopt($cURL_Connection, CURLOPT_RETURNTRANSFER, true);
     $cURL_Input = curl_exec($cURL_Connection);
     curl_close($cURL_Connection);
     return json_decode($cURL_Input,true);
}
 
?>
