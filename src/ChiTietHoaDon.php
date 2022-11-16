<?php

namespace CT275\Labs;

class ChiTietHoaDon
{

    private $db;
    private $errors = [];

    private $id = -1;
    public $so_luong, $sp_id, $hd_id;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getValidation()
    {
        return $this->errors;
    }

    public function validate()
    {
        if (!$this->sp_id)
            $this->errors["sp_id"] = "Id sản phẩm không được rỗng";
        if (!$this->hd_id)
            $this->errors["hd_id"] = "Id khách hàng không được rỗng";
        if ($this->so_luong < 1)
            $this->errors["so_luong"] = "Số lượng sản phẩm phải lớn hơn 1";

        return empty($this->errors);
    }

    public function fill(array $data, $idHoaDon)
    {
        if (isset($data["idSanPham"]))
            $this->sp_id = $data["idSanPham"];
        if (isset($idHoaDon))
            $this->hd_id = $idHoaDon;
        if (isset($data["nbSoLuong"]))
            $this->so_luong = $data["nbSoLuong"];

        return $this;
    }

    protected function fillFromDB(array $row)
    {
        [
            'id' => $this->id,
            'so_luong' => $this->so_luong,
            'sp_id' => $this->sp_id,
            'hd_id' => $this->hd_id
        ] = $row;
        return $this;
    }

    public function all()
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from chitiethoadon");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $chitiethoadon = new ChiTietHoaDon($this->db);
            $chitiethoadon->fillFromDB($row);
            $arr[] = $chitiethoadon;
        }
        return $arr;
    }

    public function save()
    {
        $result = false;
        $stmt = $this->db->prepare("INSERT INTO `chitiethoadon`(`so_luong`, `sp_id`, `hd_id`) VALUES (?,?,?)");
        $result = $stmt->execute([$this->so_luong, $this->sp_id, $this->hd_id]);
        if ($result) {
            $this->id = $this->db->lastInsertId();
        }
        return $result;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("select * from chitiethoadon where id = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function findIdHD($hd_id)
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from chitiethoadon where hd_id = ?");
        $stmt->execute([$hd_id]);
        while ($row = $stmt->fetch()) {
            $chitiethoadon = new ChiTietHoaDon($this->db);
            $chitiethoadon->fillFromDB($row);
            $arr[] = $chitiethoadon;
        }
        return $arr;
    }

    public function findIdSP($sp_id)
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from chitiethoadon where sp_id = ?");
        $stmt->execute([$sp_id]);
        while ($row = $stmt->fetch()) {
            $chitiethoadon = new ChiTietHoaDon($this->db);
            $chitiethoadon->fillFromDB($row);
            $arr[] = $chitiethoadon;
        }
        return $arr;
    }

    public function delete()
    {
        $stmt = $this->db->prepare("delete from chitiethoadon where id = ?");
        return $stmt->execute([$this->id]);
    }
}
