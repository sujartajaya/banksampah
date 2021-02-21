<?php

namespace App\Models;

use CodeIgniter\Model;


class NasabahModel extends Model
{
    public $db;
    protected $table = 'nasabah';
    protected $allowedFields = ['ukey', 'nik', 'nama', 'alamat', 'telpon', 'status'];
    protected $useTimestamps = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
