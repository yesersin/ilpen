<?php
/**
 * Kategoriye baglı tüm ürünleri getireceğimiz servistir.
 */

include_once('./dbSql.php');
include_once('./curl.php');
$db= new dbSql();
$curl = new curl();

$ids= ($db->getProductAll());

$count=0;
//foreach ($ids as $val) {  
    $url="https://webservice.ilpen.com.tr/stock_service/json_get_public_stock_by_product_code?type=group&productCode=1188"; //.$val; 
     
    $product = $curl->get($url); 
    var_dump($product);

    // if(!is_null($product) || $product!=0){ 
    //     $db->setStock($val, $product[0]["STOCK_AMOUNT"],$product[0]["STOCK_CODE"]); //$val=productCode
    //     $count++;
    // }
 
//} 

?>
