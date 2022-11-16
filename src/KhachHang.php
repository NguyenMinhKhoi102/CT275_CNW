<?php

namespace CT275\Labs;

class KhachHang
{
	private $db;
	private $id = -1;
	public $email, $matkhau, $hoten, $ngaysinh, $gioitinh, $sdt, $diachi, $rmatkhau;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['txtUserFullName'])) {
			$this->hoten = trim($data['txtUserFullName']);
		}
		if (isset($data['email'])) {
			$this->email = trim($data['email']);
		}
		if (isset($data['dtBirthday'])) {
			$this->ngaysinh = $data['dtBirthday'];
		}
		if (isset($data['rdGender'])) {
			$this->gioitinh = trim($data['rdGender']);
		}
		if (isset($data['txtAddress'])) {
			$this->diachi = trim($data['txtAddress']);
		}
		if (isset($data['pwdUser'])) {
			$this->matkhau = trim($data['pwdUser']);
		}
		if (isset($data['re_pwdUser'])) {
			$this->rmatkhau = trim($data['re_pwdUser']);
		}
		if (isset($data['sdt'])) {
			$this->sdt = $data['sdt'];
		}



		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}


	public function validateBirthday()
	{
		$minAge = strtotime("-18 YEAR");
		$entrantAge = strtotime($this->ngaysinh);

		if ($entrantAge < $minAge) {
			return false;
		}
		return true;
	}



	public function validate()
	{
		if (!$this->email) {
			$this->errors['email'] = 'Chưa nhập email!';
		} else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$this->errors['email'] = 'Email không hợp lệ!';
		} else if ($this->db->query("select * from khachhang where email = '$this->email'")->rowCount() > 0) {
			$this->errors['email'] = 'Email đã được sử dụng!';
		}

		if (!$this->hoten) {
			$this->errors['txtUserFullName'] = 'Chưa nhập họ và tên!';
		} else if ($this->hoten <= 8) {
			$this->errors['txtUserFullName'] = 'Họ tên phải lớn hơn 8 ký tự';
		}

		 
		if (!preg_match('/^[0-9]{10}+$/', $this->sdt)) {
			$this->errors['sdt'] = 'Số điện thoại phải bao gồm 10 chữ số!';
		} else if ($this->db->query("select * from khachhang where sdt = $this->sdt")->rowCount() > 0) {
			$this->errors['sdt'] = 'Số điện thoại đã được sử dụng!';
		}

		if (!$this->ngaysinh) {
			$this->errors['dtBirthday'] = 'Chưa chọn ngày sinh';
		} else if ($this->validateBirthday()) {
			$this->errors['dtBirthday'] = 'Ngày sinh không hợp lệ';
		}

		if (!$this->gioitinh) {
			$this->errors["rdGender"] = "Bạn chưa chọn giới tính";
		}

		if (!$this->diachi) {
			$this->errors["txtAddress"] = "Bạn chưa nhập địa chỉ!";
		}

		if (!$this->matkhau) {
			$this->errors["pwdUser"] = "Bạn chưa nhập mật khẩu";
		} else if (strlen($this->matkhau) < 8) {
			$this->errors["pwdUser"] = "Mật khẩu phải lớn hơn hoặc bằng 8 ký tự";
		}

		if (!$this->rmatkhau) {
			$this->errors["re_pwdUser"] = "Bạn chưa nhập lại mật khẩu";
		} else if ($this->matkhau != $this->rmatkhau) {
			$this->errors["re_pwdUser"] = "Mật khẩu không khớp";
		}
		return empty($this->errors);
	}


	public function validateLogin($email, $pass)
	{
		if (!$email) {
			$this->errors["email"] = "Bạn chưa nhập email!";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->errors["email"] = "Email không hợp lệ!";
		} else {
			$this->errors["email"] = "";
		}
		if (!$pass) {
			$this->errors["pwdUser"] = "Bạn chưa nhập mật khẩu!";
		} else if (strlen($_POST['pwdUser']) < 8) {
			$this->errors["pwdUser"] = "Mật khẩu không hợp lệ!";
		} else {
			$this->errors["pwdUser"] = "";
		}
	}

	public function Login(array $data)
	{
		$email = trim($data['email']);
		$pass = $data['pwdUser'];
		$stmt = $this->db->prepare("select * from khachhang where email = ? and matkhau = ?");
		$stmt->execute([
			$email,
			$pass
		]);
		if ($stmt->rowCount() > 0) {
			$result = $stmt->fetch();
			return $result["id"];
		}
		return 0;
	}

	public function all()
	{
		$arr = [];
		$stmt = $this->db->prepare('select * from khachhang');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$khachhang = new KhachHang($this->db);
			$khachhang->fillFromDB($row);
			$arr[] = $khachhang;
		}
		return $arr;
	}

	public function allKH()
	{
		$arr = [];
		$stmt = $this->db->prepare('select * from khachhang where vai_tro = 0');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$khachhang = new KhachHang($this->db);
			$khachhang->fillFromDB($row);
			$arr[] = $khachhang;
		}
		return $arr;
	}


	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'email' => $this->email,
			'hoten' => $this->hoten,
			'ngaysinh' => $this->ngaysinh,
			'gioitinh' => $this->gioitinh,
			'sdt' => $this->sdt,
			'diachi' => $this->diachi,
			'matkhau' => $this->matkhau
		] = $row;
		return $this;
	}


	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update khachhang
			set email = :email, matkhau = :matkhau, hoten = :hoten, ngaysinh = :ngaysinh, gioitinh = :gioitinh, sdt = :sdt, diachi = :diachi
			where id = :id');
			$result = $stmt->execute([
				'id' => $this->id,
				'email' => $this->email,
				'hoten' => $this->hoten,
				'ngaysinh' => $this->ngaysinh,
				'gioitinh' => $this->gioitinh,
				'sdt' => $this->sdt,
				'diachi' => $this->diachi,
				'matkhau' => md5($this->matkhau)
			]);
		} else {
			$stmt = $this->db->prepare('insert into khachhang 
			(email, hoten, ngaysinh, gioitinh, sdt, diachi, matkhau)
			values (:email, :hoten, :ngaysinh, :gioitinh, :sdt, :diachi, :matkhau)');
			$result = $stmt->execute([
				'email' => $this->email,
				'hoten' => $this->hoten,
				'ngaysinh' => $this->ngaysinh,
				'gioitinh' => $this->gioitinh,
				'sdt' => $this->sdt,
				'diachi' => $this->diachi,
				'matkhau' => md5($this->matkhau)
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}

	public function find($id)
	{
		$stmt = $this->db->prepare('select * from khachhang where id = :id');
		$stmt->execute(['id' => $id]);
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
		$stmt = $this->db->prepare('delete from khachhang where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
