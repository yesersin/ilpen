<?php

class dbSql
{

    public $db;

    public function __construct()
    {
        $this->db = new \MySQLi("localhost", "root", "", "ilpen") or die(mysqli_error());
        mysqli_set_charset($this->db, 'utf8');
    }

    /**
     * Yapılması gereken ilk şey tüm kategorileri almak.
     * veriler: katogirinin Id(pc_id), adı(pc_name)
     */
    public function setCategories($veriler)
    {
        $this->sonuc = $this->db->prepare('INSERT INTO kategori (pc_id,pc_name) VALUES (?,?)');
        $this->sonuc->bind_param('is', $veriler["pc_id"],  $veriler["pc_name"]);
        return $this->sonuc->execute();
    }

    /**
     * Kategorileri getirerek var olup olmama durumuna göre işlem yapıyoruz.
     * id: kategoriId
     */
    public function getId($id)
    {
        $veriler = $this->db->prepare("select id from kategori where pc_id=?");
        $veriler->bind_param("i", $id);
        $veriler->execute();
        $result = $veriler->get_result(); // get the mysqli result
        $id = $result->fetch_assoc(); // fetch the data   
        return $id;
    }

    /**
     * Tüm kategorileri getiriyorum. Amacım kategorileri alarak içindeki ürünlere erişmek
     */
    public function getIdAll()
    {
        $veriler = $this->db->query("select DISTINCT pc_id from kategori");
        $data = [];
        while ($row = $veriler->fetch_assoc()) {
            $data[] = $row["pc_id"];
        }
        return $data;
    }

    /**
     * Ürünleri topluca kayıt ediyorum. Tüm ürünleri bilgileri ile birlikte kayıt ediyorum içinde gezmek daha rahat olacak.
     * id: kategoriId(pc_id)
     * u: o kategorideki tüm ürünler.
     */
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

    /**
     * Ürünleri ürün koduna göre getiriyorum. Amaç aynı ürünü ikikere kayıt etmemek için sorgulamaktır.
     * product_code : ürünün uniq kodu, id 'si
     */
    public function getProduct($product_code)
    {
        $veriler = $this->db->prepare("select id from urunler where product_code=?");
        $veriler->bind_param("s", $product_code);
        $veriler->execute();
        $result = $veriler->get_result(); // get the mysqli result
        $id = $result->fetch_assoc(); // fetch the data   
        return $id;
    }

    /**
     * Tüm ürünleri benzersiz olarak çekiyoruz.
     */
    public function getProductAll()
    {
        $veriler = $this->db->query("select DISTINCT product_code from urunler");
        $data = [];
        while ($row = $veriler->fetch_assoc()) {
            $data[] = $row["product_code"];
        }
        return $data;
    }

    /**
     * Stokları ayrıca bir servis verdiği için ayrıca güncelleme yapıyorum.
     * productCode: ürüne ait benzersiz Id (product_code olarakta geçiyor)
     * STOCK_AMOUNT: ürünün güncel stok bilgisi
     */
    public function setStock($productCode, $STOCK_AMOUNT,$STOCK_CODE)
    { 
        $this->sonuc = $this->db->prepare('Update urunler SET STOCK_AMOUNT=?,STOCK_CODE=? WHERE product_code=?');
        $this->sonuc->bind_param('sss',   $STOCK_AMOUNT,$STOCK_CODE, $productCode);
        $this->sonuc->execute(); 
    }

}
