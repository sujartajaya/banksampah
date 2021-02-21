<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Altersaldo extends Migration
{
	public function up()
	{
		$fields = [
			'rek' => [
				'name' => 'rekening',
				'type'       => 'VARCHAR',
				'constraint' => '50',
			]
		];
		$this->forge->modifyColumn('saldo', $fields);
	}

	public function down()
	{
		$fields = [
			'rekening' => [
				'name' => 'rek',
				'type'       => 'VARCHAR',
				'constraint' => '50',
			]
		];
		$this->forge->modifyColumn('saldo', $fields);
	}
}
