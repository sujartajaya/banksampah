<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaldoModel;
use CodeIgniter\I18n\Time;

class Saldo extends BaseController
{
	private $saldo_model;

	public function __construct()
	{
		$this->saldo_model = new SaldoModel();
	}

	public function index()
	{
		//return view('errors/html/error_404');
		$result = $this->saldo_model->baca_semua_saldo();
		if ($result->getNumRows() > 0) {
			//dd($result->getResultArray());
			echo json_encode($result->getResultArray());
		}
	}

	public function tambah_saldo_baru()
	{
		$rek = '1545618902';
		$simpan = $this->saldo_model->saldo_baru($rek);
		echo $simpan;
	}

	public function update_saldo()
	{
		// $rek = '1545618902';
		// $result = $this->saldo_model->update_saldo($rek, '10000', '2020-02-21');
		// echo $result;

		$data = [
			'saldo' => 10000,
			'tglsaldo' => '2021-02-21'
		];
		$id = 1;
		$update = $this->saldo_model->update($id, $data);
		if ($update) {
			echo "Berhasil";
		} else {
			echo "Gagagal";
		}
	}
}
