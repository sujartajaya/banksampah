<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterNasabah extends Migration
{
	public function up()
	{
		$this->forge->addColumn('nasabah', [
			'userlogin VARCHAR(1) NULL AFTER status'
		]);
	}

	public function down()
	{
		$this->forge->dropColumn('nasabah', 'userlogin');
	}
}
