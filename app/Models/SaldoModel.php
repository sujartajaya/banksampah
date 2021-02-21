<?php

namespace App\Models;

use CodeIgniter\Model;

class SaldoModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'saldo';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['saldo', 'rekening', 'tglsalo'];
	protected $db;

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	public function saldo_baru($rek)
	{
		$sekarang = date('Y-m-d');
		$update = date('Y-m-d H:i:s');
		$sql = "INSERT INTO `saldo` (`rekening`,`saldo`,`tglsaldo`,`created_at`,`updated_at`) VALUES (?,?,?,?,?)";
		$result = $this->db->query($sql, [$rek, 0, $sekarang, $update, $update]);
		return $result;
	}

	public function baca_semua_saldo()
	{
		$sql = "SELECT * FROM `saldo`";
		$result  = $this->db->query($sql);
		return $result;
	}

	public function update_saldo($rek, $saldo, $tglsaldo)
	{
		$update = date('Y-m-d H:i:s');
		$sql = "UPDATE `saldo` SET `saldo` = $saldo, `tglsaldo` = $tglsaldo, `update_at` = $update  WHERE `rekening` = '$rek'";
		$result  = $this->db->query($sql);
		if ($result) {
			return "Berhasil update";
		} else {
			return $this->db->error();
		}
	}
}
