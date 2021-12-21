<?php

class dbSql
{

    public $db;

    public function __construct()
    {
        $this->db = new \MySQLi("localhost", "root", "", "ilpen") or die(mysqli_error());
        mysqli_set_charset($this->db, 'utf8');
    }

    public function mysql()
    {
        return $this->db;
    }


    public function setCategories($veriler)
    {
        $this->sonuc = $this->db->prepare('INSERT INTO kategori (pc_id,pc_name) VALUES (?,?)');
        $this->sonuc->bind_param('is', $veriler["pc_id"],  $veriler["pc_name"]);
        return $this->sonuc->execute();
    }

    public function getId($id)
    {
        $veriler = $this->db->prepare("select id from kategori where pc_id=?");
        $veriler->bind_param("i", $id);
        $veriler->execute();
        $result = $veriler->get_result(); // get the mysqli result
        $id = $result->fetch_assoc(); // fetch the data   
        return $id;
    }

    public function getIdAll()
    {
        $veriler = $this->db->query("select DISTINCT pc_id from kategori");
        $data = [];
        while ($row = $veriler->fetch_assoc()) {
            $data[] = $row["pc_id"];
        }
        return $data;
    }

    public function setProduct($id, $u)
    {
        $g = 0;
        $i = 0;
        foreach ($u as $key => $value) { 

            if (is_null($this->getProduct($value["product_code"]))) { //Eğer ürün daha once girilmediyse yani null sa önce kayıt et
                $this->sonuc = $this->db->prepare('INSERT INTO urunler (kategoriId, product_id, pc_id, product_code, product_name, product_description, price, status, file_name) VALUES (?,?,?,?,?,?,?,?,?)');
                $this->sonuc->bind_param('issssssis', $id, $value["product_id"], $value["pc_id"], $value["product_code"], $value["product_name"], $value["product_description"], $value["price"], $value["status"], $value["file_name"]);
                $this->sonuc->execute();
                $i++;
            } else {//ürünleri çek ve güncelle
                $this->sonuc = $this->db->prepare('Update urunler SET kategoriId=?, product_id=?, pc_id=?, product_code=?, product_name=?, product_description=?, price=?, status=?, file_name=? WHERE product_code=?');
                $this->sonuc->bind_param('issssssisi', $id, $value["product_id"], $value["pc_id"], $value["product_code"], $value["product_name"], $value["product_description"], $value["price"], $value["status"], $value["file_name"], $value["product_code"]);
                $this->sonuc->execute();
                $g++;
            }
        }
        return "Kayıt: ".$i." Guncelle: ".$g; 

    }

    public function getProduct($product_code)
    {
        $veriler = $this->db->prepare("select id from urunler where product_code=?");
        $veriler->bind_param("s", $product_code);
        $veriler->execute();
        $result = $veriler->get_result(); // get the mysqli result
        $id = $result->fetch_assoc(); // fetch the data   
        return $id;
    }

    public function getProductAll()
    {
        $veriler = $this->db->query("select DISTINCT product_code from urunler");
        $data = [];
        while ($row = $veriler->fetch_assoc()) {
            $data[] = $row["product_code"];
        }
        return $data;
    }

    public function setStock($productCode, $STOCK_AMOUNT)
    { 
        $this->sonuc = $this->db->prepare('Update urunler SET STOCK_AMOUNT=? WHERE product_code=?');
        $this->sonuc->bind_param('ss',   $STOCK_AMOUNT, $productCode);
        $this->sonuc->execute(); 
    }

}
