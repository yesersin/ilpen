<?php
 
class dbSql {

    public $db;

    public function __construct() {
        $this->db = new \MySQLi("localhost", "root", "5964625e", "ilpen") or die(mysqli_error());
        mysqli_set_charset($this->db, 'utf8');
    }

    public function mysql() {
        return $this->db;
    }
 

    public function sonuc($veriler, $single) {
        $sonuc = "";
        if ($single) { //1:tekli 
            while ($row = $veriler->fetch_array(MYSQLI_ASSOC)) {
                $sonuc = $row;
            }
        } else { //0: çoklu
            $sonuc = array();
            while ($row = $veriler->fetch_array(MYSQLI_ASSOC)) {
                $sonuc[] = $row;
            }
        }
        return $sonuc;
    }

}
