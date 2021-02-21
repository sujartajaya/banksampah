<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
			'username'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'unique'         => true,

			],
			'ukey'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'unique'         => true,

			],
			'password'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'email'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'unique'         => true,

			],
			'usertype' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
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
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
