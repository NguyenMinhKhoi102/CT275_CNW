<?php

namespace CT275\Labs;

class SanPham
{
	private $db;
	private $id = -1;
	public $tensanpham, $gia, $kichthuoc, $mota, $nhanhieu, $hinhanh, $gioitinh, $giamgia;
	protected $loai_id;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}
	public function getLoai_Id()
	{
		return $this->loai_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['txtTenSanPham'])) {
			$this->tensanpham = trim($data['txtTenSanPham']);
		}
		if (isset($data['nbGia'])) {
			$this->gia = trim($data['nbGia']);
		}
		if (isset($data['txtKichThuoc'])) {
			$this->kichthuoc = trim($data['txtKichThuoc']);
		}
		if (isset($data['txtNhanHieu'])) {
			$this->nhanhieu = trim($data['txtNhanHieu']);
		}
		if (isset($data['nbGiamGia'])) {
			$this->giamgia = trim($data['nbGiamGia']);
		}
		if (isset($data['slLoai'])) {
			$this->loai_id = trim($data['slLoai']);
		}
		if (isset($data['rdGioiTinh'])) {
			$this->gioitinh = trim($data['rdGioiTinh']);
		}

		if (isset($data['txtMoTa'])) {
			$this->mota = trim($data['txtMoTa']);
		}


		return $this;
	}

	public function validateImage($temp, $targetFile)
	{
		$hasErrors = false;
		$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
		$extensions = array("jpeg", "jpg", "png", "gif");
		$check = getimagesize($temp);
		if ($check !== false) {
			$hasErrors = false;
		} else {
			$this->errors["hinhanh"] = "Đây không phải là file ảnh";
			$hasErrors = true;
		}
		if (file_exists($targetFile)) {
			$this->errors["hinhanh"] = "Ảnh đã tồn tại.";
			$hasErrors = true;
		}
		if (!in_array($imageFileType, $extensions)) {
			$this->errors["hinhanh"] =  "Ảnh chỉ chứ đuôi jpeg, jpg, png, gif";
			$hasErrors = true;
		}
		return $hasErrors;
	}


	public function uploadImage($base, $temp)
	{
		$targetDir = "uploads/";
		$imgProDuctName = date("YmdHis") . '_' . basename($base);
		$targetFile = $targetDir . $imgProDuctName;

		if (!$this->validateImage($temp, $targetFile)) {
			if (move_uploaded_file($temp, $targetFile)) {
				$this->hinhanh = $imgProDuctName;
				return true;
			}
		}
		return false;
	}



	public function removeImage()
	{
		$fileName = $this->hinhanh;
		if (file_exists("uploads/$fileName") && $fileName !== "no-image-available.png" && $fileName != '') {
			if (unlink("uploads/$fileName")) {
				$this->hinhanh = "no-image-available.png";
			}
		}
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->tensanpham) {
			$this->errors['tensanpham'] = 'Bạn chưa nhập tên sản phẩm!';
		}
		if (!$this->gia) {
			$this->errors['gia'] = 'Bạn chưa nhập giá sản phẩm!';
		}
		if (!$this->kichthuoc) {
			$this->errors['kichthuoc'] = 'Bạn chưa nhập kích thước!';
		}
		if (!$this->nhanhieu) {
			$this->errors['nhanhieu'] = 'Bạn chưa nhập nhãn hiệu!';
		}

		if ($this->getLoai_Id() == 0) {
			$this->errors['loai_id'] = 'Bạn chưa chọn loại sản phẩm!';
		}
		if (!$this->gioitinh) {
			$this->errors['gioitinh'] = 'Bạn chọn giới tính phù hợp với sản phẩm!';
		}


		if (!$this->mota) {
			$this->errors['mota'] = 'Bạn chưa nhập mô tả sản phẩm!';
		}
		return empty($this->errors);
	}

	public function all()
	{
		$arr = [];
		$stmt = $this->db->prepare('select * from sanpham');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
	}

	public function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'tensanpham' => $this->tensanpham,
			'gia' => $this->gia,
			'kich_thuoc' => $this->kichthuoc,
			'mo_ta' => $this->mota,
			'nhan_hieu' => $this->nhanhieu,
			'hinh_anh' => $this->hinhanh,
			'gioi_tinh' => $this->gioitinh,
			'giam_gia' => $this->giamgia,
			'loai_id' => $this->loai_id
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update sanpham
			set tensanpham = :ten, gia = :g, kich_thuoc = :kt, mo_ta = :mt, nhan_hieu = :nh, hinh_anh = :ha, gioi_tinh = :gt, loai_id = :l, giam_gia = :gg
			where id = :id');
			$result = $stmt->execute([
				'id' => $this->id,
				'ten' => $this->tensanpham,
				'g' => $this->gia,
				'kt' => $this->kichthuoc,
				'mt' => $this->mota,
				'nh' => $this->nhanhieu,
				'ha' => $this->hinhanh,
				'gt' => $this->gioitinh,
				'l' => $this->loai_id,
				'gg' => $this->giamgia
			]);
		} else {
			$stmt = $this->db->prepare('insert into sanpham
			(tensanpham, gia, kich_thuoc, mo_ta, nhan_hieu, hinh_anh, gioi_tinh, loai_id, giam_gia)
			values (:ten, :g, :kt, :mt, :nh, :ha, :gt, :l, :gg)');
			$result = $stmt->execute([
				'ten' => $this->tensanpham,
				'g' => $this->gia,
				'kt' => $this->kichthuoc,
				'mt' => $this->mota,
				'nh' => $this->nhanhieu,
				'ha' => $this->hinhanh,
				'gt' => $this->gioitinh,
				'l' => $this->loai_id,
				'gg' => $this->giamgia
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		}
		return $result;
	}

	public function find($id)
	{
		$stmt = $this->db->prepare('select * from sanpham where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}


	public function findByBrand($str)
	{
		$arr = [];
		$stmt = $this->db->prepare("select * from sanpham where nhan_hieu like :nh");
		$stmt->execute(['nh' => '%' . $str . '%']);
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
	}

	public function findByName($str)
	{
		$arr = [];
		$stmt = $this->db->prepare("select * from sanpham where tensanpham like :ten");
		$stmt->execute(['ten' => '%' . $str . '%']);
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
	}

	public function findByOptions(array $data)
	{
		$sql = "select s.* from sanpham s join loaisanpham l on s.loai_id = l.id where ";
		$strGioiTinh = "s.gioi_tinh like ";
		$strLoai = " (l.tenloai like ";
		$strMucGia = "s.gia <= ";
		$strThuongHieu = " and s.nhan_hieu like ";
		$strXapSep = " order by gia";
		if (isset($data["chkGioiTinh"]) && !empty($data["chkGioiTinh"])) {
			$strGioiTinh = $strGioiTinh . implode(" or s.gioi_tinh like ", $data["chkGioiTinh"]);
			$sql = $sql . $strGioiTinh;
		}
		if (isset($data["chkLoai"]) && !empty($data["chkLoai"])) {
			if (!empty($data["chkGioiTinh"])) {
				$strLoai = " and " . $strLoai;
			}
			$strLoai = $strLoai . implode(" or l.tenloai like ", $data["chkLoai"]);
			$strLoai = $strLoai . ")";
			$sql = $sql . $strLoai;
		}
		if (isset($data["rgMucGia"])) {
			if (!empty($data["chkGioiTinh"]) || !empty($data["chkLoai"])) {
				$strMucGia = " and " . $strMucGia;
			}

			$strMucGia = $strMucGia . $data["rgMucGia"];
			$sql = $sql . $strMucGia;
		}
		if (isset($data["slThuongHieu"]) && !empty($data["slThuongHieu"])) {

			$strThuongHieu = $strThuongHieu . $data["slThuongHieu"];
			$sql = $sql . $strThuongHieu;
		}
		if (isset($data["boLoc"]) && !empty($data["boLoc"])) {
			if ($data["boLoc"] == 1)
				$strXapSep = $strXapSep . ' DESC';
			else
				$strXapSep = $strXapSep . ' ASC';
			$sql = $sql . $strXapSep;
		}
		$arr = [];
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
	}


	public function search($str)
	{
		$arr = [];
		$stmt = $this->db->prepare("
			SELECT s.id as id, tensanpham, gia, kich_thuoc, mo_ta, nhan_hieu, hinh_anh, gioi_tinh, loai_id, giam_gia FROM sanpham s JOIN loaisanpham l ON s.loai_id = l.id
			WHERE s.tensanpham LIKE :str OR s.kich_thuoc LIKE :str OR s.mo_ta LIKE :str or
			s.nhan_hieu like :str OR s.gioi_tinh like :str OR l.tenloai LIKE :str;
		");
		$stmt->execute(['str' => '%' . $str . '%']);
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
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
		$stmt = $this->db->prepare('delete from sanpham where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}


	public function findLoaiSP($idloai){
		$arr = [];
		$stmt = $this->db->prepare("select * from sanpham where loai_id = :nh");
		$stmt->execute(['nh' =>  $idloai]);
		while ($row = $stmt->fetch()) {
			$sanPham = new SanPham($this->db);
			$sanPham->fillFromDB($row);
			$arr[] = $sanPham;
		}
		return $arr;
	}
}
