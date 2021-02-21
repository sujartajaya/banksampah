<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Users extends Seeder
{
	public function run()
	{

		$datausers = [
			[
				'username' => 'admin01',
				'ukey' => md5(uniqid('admin01', true)),
				'password' => md5('putu123'),
				'email' => 'admin01@yahoo.com',
				'usertype' => 'Admin',
				'status' => '0',
				'created_at' => Time::now('Asia/Makassar', 'en_US'),
				'updated_at' => Time::now('Asia/Makassar', 'en_US')
			],
			[
				'username' => 'admin02',
				'ukey' => md5(uniqid('admin02', true)),
				'password' => md5('putu123'),
				'email' => 'admin02@yahoo.com',
				'usertype' => 'Admin',
				'status' => '0',
				'created_at' => Time::now('Asia/Makassar', 'en_US'),
				'updated_at' => Time::now('Asia/Makassar', 'en_US')
			],
			[
				'username' => 'user01',
				'ukey' => md5(uniqid('user01', true)),
				'password' => md5('putu123'),
				'email' => 'user01@yahoo.com',
				'usertype' => 'Nasabah',
				'status' => '0',
				'created_at' => Time::now('Asia/Makassar', 'en_US'),
				'updated_at' => Time::now('Asia/Makassar', 'en_US')
			],
		];
		foreach ($datausers as $data) {
			// insert semua data ke tabel
			$this->db->table('users')->insert($data);
		}
	}
}
