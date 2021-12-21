<?php
/**
 * Ilpene kayıtlı kategorileri ve id lerini alıyoruz.
 * pc_id : kategorinin ID 'si
 */
include_once('./dbSql.php');
include_once('./curl.php');
$db= new dbSql();
$curl = new curl();
 
$categorie = $curl->get("https://b2b.ilpen.com.tr/ilpenB2BWebSiteService/jsonapi/list_categories"); 

foreach ($categorie as $key => $value) {
    $say++;
   if(is_null($db->getId($value["pc_id"]))){ //eğer kategori daha once girildiyse bir işlem yapmasın
        $db->setCategories($value);
   }
}
echo "Güncellenen:".$say;
?>
