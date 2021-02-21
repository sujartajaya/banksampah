<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Saldo extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'rek'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'unique'         => true,

			],
			'saldo'       => [
				'type'       => 'DOUBLE',

			],
			'tglsaldo'       => [
				'type'       => 'DATE',
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('saldo');
	}

	public function down()
	{
		$this->forge->dropTable('saldo');
	}
}
