<?php

namespace CT275\Labs;

class HoaDon
{

    private $db;
    private $errors = [];

    private $id = -1;
    public $ngaylap, $trangthai, $kh_id, $thanhtien;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    
    public function fill($idkh, $soTien)
    {
        if (isset($idkh)) {
            $this->kh_id = $idkh;
        }
        if (isset($soTien)) {
            $this->thanhtien = $soTien;
        }
        return $this;
    }

    public function getValidation()
    {
        return $this->errors;
    }

    public function validate()
    {
        if (!$this->kh_id)
            $this->errors["kh_id"] = "Chưa nhập id người dùng";
        else if ($this->kh_id < 1)
            $this->errors["kh_id"] = "id người dùng không hợp lệ";

        return empty($this->errors);
    }

    public function all()
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from hoadon");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $hoadon = new HoaDon($this->db);
            $hoadon->fillFromDB($row);
            $arr[] = $hoadon;
        }
        return $arr;
    }


    protected function fillFromDB(array $row)
    {
        [
            "id" => $this->id,
            "ngaylap" => $this->ngaylap,
            "trangthai" => $this->trangthai,
            "kh_id" => $this->kh_id,
            "thanhtien" => $this->thanhtien
        ] = $row;
        return $this;
    }

    public function save()
    {
        $result = false;
        if ($this->id >= 0) {
            $stmt = $this->db->prepare("update hoadon set trangthai = 1 where id = ?");
            $result = $stmt->execute([$this->id]);
        } else {
            $stmt = $this->db->prepare("insert into hoadon (ngaylap, kh_id, thanhtien) values (now(), ?, ?)");
            $result = $stmt->execute([$this->kh_id, $this->thanhtien]);
            if ($result) {
                $this->id = $this->db->lastInsertId();
            }
        }
        return $result;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("select * from hoadon where id = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function findKH($kh_id)
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from hoadon where kh_id = ? order by id desc");
        $stmt->execute([$kh_id]);
        while ($row = $stmt->fetch()) {
            $hoadon = new HoaDon($this->db);
            $hoadon->fillFromDB($row);
            $arr[] = $hoadon;
        }
        return $arr;
    }

    public function delete()
    {
        $stmt = $this->db->prepare("delete from hoadon where id = ?");
        return $stmt->execute([$this->id]);
    }
}
