<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MyQrcode;

class Userlogin extends BaseController
{
	private $user_model;

	public function __construct()
	{
		$this->user_model = new \App\Models\UserModel;
	}

	public function index()
	{
		return view('errors/html/error_404');
	}

	public function tambah_userlogin_baru()
	{
		$user_model = $this->user_model;
		if ($this->request->isAJAX()) {
			$validation =  \Config\Services::validation();
			if (!$this->validate([
				'user_login_username' => 'required|min_length[5]|max_length[100]|is_unique[users.username]',
				'user_login_email' => 'required|valid_email|is_unique[users.email]',
				'user_login_password' => 'required'
			])) {
				$this->output['errors'] = $validation->getErrors();
				echo json_encode($this->output);
			} else {
				$user = [
					'username' => $this->request->getVar('user_login_username'),
					'ukey' => $this->request->getVar('user_login_ukey'),
					'password' => md5($this->request->getVar('user_login_password')),
					'email' => $this->request->getVar('user_login_email'),
					'usertype' => 'Nasabah',
					'status' => '1'
				];
				$save = $user_model->save($user);
				if ($save) {
					$mynasabah = new $this->user_model;
					$mykolom = ['ukey', 'nik', 'rekening', 'nama', 'alamat', 'telpon', 'userlogin', 'status'];
					$mytable = 'nasabah';
					$mynasabah->setAllowedFields($mykolom);
					$mynasabah->setTable($mytable);
					$data = ['userlogin' => '1'];
					$updatenasabah = $mynasabah->update($this->request->getVar('user_login_id'), $data);
					if ($updatenasabah) {
						$this->output['success'] = true;
						$this->output['message'] = 'Record has been added successfully.';
						echo json_encode($this->output);
					}
				} else {
					$this->output['errors'] = ['user_login_email' => 'Gagal simpan.'];
					echo json_encode($this->output);
				}
			}
		}
	}
}
