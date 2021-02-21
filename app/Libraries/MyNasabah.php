<?php

namespace App\Libraries;

use CodeIgniter\Model;

class MyNasabah
{
    private $mymodel;
    private $mykolom = ['ukey', 'nik', 'rekening', 'nama', 'alamat', 'telpon', 'userlogin', 'status'];
    private $mytable = 'nasabah';

    public function __construct()
    {
        $this->mymodel = new Modelku();
        $this->mymodel->setAllowedFields($this->mykolom);
        $this->mymodel->setTable($this->mytable);
    }

    public function setMymodel($model)
    {
        $this->mymodel = $model;
    }

    public function setMykolom($kolom)
    {
        $this->mykolom = $kolom;
        $this->mymodel->setAllowedFields($kolom);
    }

    public function setMytable($table)
    {
        $this->mytable = $table;
        $this->mymodel->setTable($table);
    }

    public function UpdateData($id, $data)
    {
        $update = $this->mymodel->update($id, $data);
        return $update;
    }
}

class Modelku extends Model
{
    public function __construct()
    {
        parent::__construct();
        \Config\Database::connect();
    }
}
