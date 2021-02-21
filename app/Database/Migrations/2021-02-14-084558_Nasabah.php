<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nasabah extends Migration
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
			'ueky'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'unique'         => true,

			],
			'nik'       => [
				'type'       => 'VARCHAR',
				'constraint' => '25',
				'unique'         => true,

			],
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'alamat'       => [
				'type'       => 'VARCHAR',
				'constraint' => '500',
			],
			'telpon' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
			],
			'status' => [
				'type' => 'VARCHAR',
				'constraint' => '1',
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
		$this->forge->createTable('nasabah');
	}

	public function down()
	{
		$this->forge->dropTable('nasabah');
	}
}
