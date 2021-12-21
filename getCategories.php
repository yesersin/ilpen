<?php
/**
 * Ilpene kayıtlı kategorileri ve id lerini alıyoruz.
 * pc_id : kategorinin ID 'si
 */
include_once('./dbSql.php');
$db= new dbSql();

$url="https://b2b.ilpen.com.tr/ilpenB2BWebSiteService/jsonapi/list_categories";
$cURL_Connection = curl_init($url);
curl_setopt($cURL_Connection, CURLOPT_RETURNTRANSFER, true);
$cURL_Input = curl_exec($cURL_Connection);
curl_close($cURL_Connection);
$jSON_Array = json_decode($cURL_Input,true);
 
$say=0;
 
foreach ($jSON_Array as $key => $value) {
    $say++;
   if(is_null($db->getId($value["pc_id"]))){ //eğer kategori daha once girildiyse bir işlem yapmasın
        $db->setCategories($value);
   }
}
 
echo "Güncellenen:".$say;
?>
