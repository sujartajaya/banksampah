<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
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
			'rekenaing'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
			],
			'saldo'       => [
				'type'       => 'DOUBLE',

			],
			'tglsaldo'       => [
				'type'       => 'DATE',
			],
			'tgltrk'       => [
				'type'       => 'DATE',
			],
			'jumlah'       => [
				'type'       => 'DOUBLE',
			],
			'type'       => [
				'type'       => 'VARCHAR(1)',
			],
			'keterangan'       => [
				'type'       => 'VARCHAR(200)',
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
		$this->forge->createTable('transaksi');
	}

	public function down()
	{
		$this->forge->dropTable('transaksi');
	}
}
