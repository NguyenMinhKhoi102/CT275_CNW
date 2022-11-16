<?php

namespace CT275\Labs;

class LoaiSanPham {
	private $db;
	private $id = -1;
	public $tenloai;
	private $errors = [];

	public function getId() {
		return $this->id;
	}

	public function __construct($pdo) {
		$this->db = $pdo;
	}

	public function fill(array $data) {
		if (isset($data['txtTenLoai'])) {
			$this->tenloai = $data['txtTenLoai'];
		}
		return $this;
	}

	public function getValidationErrors() {
		return $this->errors;
	}

	public function validate() {
		if (!$this->tenloai) {
			$this->errors['txtTenLoai'] = 'Chưa nhập tên loại!';
		} 
		return empty($this->errors);
	}
	
	public function all() {
		$arr = [];
		$stmt = $this->db->prepare('select * from loaisanpham');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$loaiSanPham = new LoaiSanPham($this->db);
			$loaiSanPham->fillFromDB($row);
			$arr[] = $loaiSanPham;
		}
		return $arr;
	}
	
	protected function fillFromDB(array $row) {
		[	'id' => $this->id,
			'tenloai' => $this->tenloai
		] = $row;
		return $this;
	}

	public function save() {
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update loaisanpham
			set tenloai = :ten
			where id = :id');
			$result = $stmt->execute([
				'id' => $this->id,
				'ten' => $this->tenloai
			]);
		} else {
			$stmt = $this->db->prepare('insert into loaisanpham 
			(tenloai)
			values (:ten)');
			$result = $stmt->execute([
				'ten' => $this->tenloai
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}
	
	public function find($id) {
		$stmt = $this->db->prepare('select * from loaisanpham where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	
	public function update(array $data) {
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}


	public function delete() {
		$stmt = $this->db->prepare('delete from loaisanpham where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}

}
