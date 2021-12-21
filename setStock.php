<?php
/**
 * Kategoriye baglı tüm ürünleri getireceğimiz servistir.
 */

include_once('./dbSql.php');
$db= new dbSql();

$ids= ($db->getProductAll());

$count=0;
foreach ($ids as $val) {
    $url="https://webservice.ilpen.com.tr/stock_service/json_get_public_stock_by_product_code?type=group&productCode=".$val;
    $product = get($url); 
    if(!is_null($product) || $product!=0){
        $db->setStock($val, $product["STOCK_AMOUNT"]); //$val=productCode
        $count++;
    }
}


echo $count;
function get($url) {
     $cURL_Connection = curl_init($url);
     curl_setopt($cURL_Connection, CURLOPT_RETURNTRANSFER, true);
     $cURL_Input = curl_exec($cURL_Connection);
     curl_close($cURL_Connection);
     return json_decode($cURL_Input,true);
}
?>
