<?php

namespace CT275\Labs;

class GioHang
{

    private $db;
    private $errors = [];
    private $id = -1;

    public $sp_id, $kh_id, $so_luong;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function fill(array $data)
    {
        if (isset($data["sp_id"]))
            $this->sp_id = $data["sp_id"];
        if (isset($data["kh_id"]))
            $this->kh_id = $data["kh_id"];
        if (isset($data["so_luong"]))
            $this->so_luong = $data["so_luong"];
        return $this;
    }

    public function getValidation()
    {
        return $this->errors;
    }

    public function validate()
    {
        if ($this->sp_id < 1)
            $this->errors["sp_id"] = "Id sản phẩm không hợp lệ";
        if ($this->kh_id < 1)
            $this->errors["kh_id"] = "Id khách hàng không hợp lệ";
        if ($this->so_luong < 1)
            $this->errors["so_luong"] = "Số lượng sản phẩm không hợp lệ";

        return empty($this->errors);
    }

    public function fillFromDB($row)
    {
        [
            "id" => $this->id,
            "sp_id" => $this->sp_id,
            "kh_id" => $this->kh_id,
            "so_luong" => $this->so_luong
        ] = $row;
        return $this;
    }

    public function all()
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from giohang");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $giohang = new GioHang($this->db);
            $giohang->fillFromDB($row);
            $arr[] = $giohang;
        }
        return $arr;
    }

    public function save()
    {
        $result = false;
        if ($this->id >= 0) {
            $stmt = $this->db->prepare('update giohang
			set so_luong = :so_luong
			where id = :id');
            $result = $stmt->execute([
                'id' => $this->id,
                'so_luong' => $this->so_luong
            ]);
        } else {
            $stmt = $this->db->prepare('insert into giohang 
			(sp_id, kh_id, so_luong)
			values (:sp_id, :kh_id, :so_luong)');
            $result = $stmt->execute([
                "sp_id" => $this->sp_id,
                "kh_id" => $this->kh_id,
                "so_luong" => $this->so_luong
            ]);
            if ($result) {
                $this->id = $this->db->lastInsertId();
            }
        }
        return $result;
    }

    public function findKH_SP(array $data)
    {
        $stmt = $this->db->prepare("select * from giohang where sp_id = ? and kh_id = ?");
        $stmt->execute([$data["sp_id"], $data["kh_id"]]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function findKH($kh_id)
    {
        $arr = [];
        $stmt = $this->db->prepare("select * from giohang where kh_id = ?");
        $stmt->execute([$kh_id]);
        while ($row = $stmt->fetch()) {
            $giohang = new GioHang($this->db);
            $giohang->fillFromDB($row);
            $arr[] = $giohang;
        }
        return $arr;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("select * from giohang where id = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function update(array $data)
    {
        $this->fill($data);
        if ($this->validate()) {
            return $this->save();
        }
        return false;
    }

    public function delete()
    {
        $stmt = $this->db->prepare("delete from giohang where id = ?");
        return $stmt->execute([$this->id]);
    }
}
