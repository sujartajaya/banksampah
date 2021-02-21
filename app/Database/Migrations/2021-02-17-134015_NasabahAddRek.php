<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NasabahAddRek extends Migration
{
	public function up()
	{
		$this->forge->addColumn('nasabah', [
			'rekening VARCHAR(50) NULL AFTER nik'
		]);
	}

	public function down()
	{
		$this->forge->dropColumn('nasabah', 'rekening');
	}
}
