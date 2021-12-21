<?php
/**
 * Kategoriye baglı tüm ürünleri getireceğimiz servistir.
 */

include_once('./dbSql.php');
include_once('./curl.php');
$db= new dbSql();
$curl = new curl();

$ids= ($db->getIdAll());
foreach ($ids as $val) {
     $url="https://b2b.ilpen.com.tr/ilpenB2BWebSiteService/jsonapi/list_category_products/?idCategory=".$val;
     $product = $curl->get($url); 
     $db->setProduct($val, $product[2]);
}

?>
