<?php

namespace App\Controllers;

use App\Libraries\MyEncrypt;
use CodeIgniter\I18n\Time;
use App\Libraries\MyQrcode;
use App\Libraries\MyNasabah;

class Nasabah extends BaseController
{

    public $user_model;
    public $myencrypt;
    public $myqrcode;
    public $saldo_model;

    public $output = [
        'success'   => false,
        'message'   => '',
        'data'      => []
    ];

    public function __construct()
    {
        $this->user_model = new \App\Models\UserModel;
        $this->saldo_model = new \App\Models\SaldoModel;

        $this->myencrypt = new MyEncrypt();
        $this->myencrypt->setKey('aBigsecret_ofAtleast32Characters');
        $this->myqrcode = new MyQrcode();
    }

    public function index()
    {
        // $nasabahmodel = new MyNasabah();
        // $data = [
        //     'userlogin' => '1'
        // ];
        // $update = $nasabahmodel->UpdateData('7', $data);
        // if ($update) {
        //     return view('errors/html/error_404');
        // } else echo "GAGAL";
        return view('errors/html/error_404');
    }

    public function nasabah_ajax_list()
    {
        $user_model = $this->user_model;

        $where = ['id' != 0];
        $column_order = array('', '', 'nik', 'rekening', 'nama', 'alamat', 'telpon', 'status', 'userlogin');
        $column_search = array('nik', 'rekening', 'nama', 'alamat');
        $order = array('nama' => 'ASC');
        $list = $user_model->get_datatables('nasabah', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            if ($lists->status != $this->STATUS_USER_REGISTER) {
                $classdisable = 'class="disable-link"';
            } else $classdisable = '';

            $view = '<a href="#" onclick="tampil_data_nasabah(' . $lists->id . ') "title="View"><span style="font-size: 1em; color: Mediumslateblue;"><i class="fa fa-eye"></i></span></a>';

            $edit = '<a href="#" onclick="form_edit_nasabah(' . $lists->id . ') "title="Edit"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-edit"></i></span></a>';

            $delete = '<a href="#" ' . $classdisable . ' onclick="delete_record(' . $lists->id . ') "title="Delete"><span style="font-size: 1em; color: Tomato;"><i class="fa fa-trash" ></i></span></a>';


            $activasi = '<a href="#" ' . $classdisable . ' onclick="activasi_user(' . $lists->id . ')" title="Activasi"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-address-card" aria-hidden="true"></i></span></a>';

            $login = '<a href="#" onclick="form_user_login(' . $lists->id . ') "title="User login"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-user-secret" aria-hidden="true"></i></span></a>';

            $row[]  = $view . '&nbsp;&nbsp;' . $edit . '&nbsp;&nbsp;' . $login . '&nbsp;&nbsp;' . $delete;
            $row[]  = $no;
            $row[]  = $lists->nik;
            $row[]  = $lists->rekening;
            $row[]  = $lists->nama;
            $row[]  = $lists->alamat;
            $row[]  = $lists->telpon;
            $row[]  = $this->STATUS_USER[$lists->status];
            $row[]  = $lists->userlogin;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $user_model->count_all('nasabah', $where),
            "recordsFiltered" => $user_model->count_filtered('nasabah', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function simpan_nasabah_baru()
    {

        $nasabah = $this->user_model;
        $kolom = ['ukey', 'nik', 'rekening', 'nama', 'alamat', 'telpon', 'userlogin', 'status'];
        $nasabah->setAllowedFields($kolom);
        $nasabah->setTable('nasabah');
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            if (!$this->validate([
                'user_nik' => 'required|is_unique[nasabah.nik]',
                'user_nama' => 'required',
                'user_alamat' => 'required',
                'user_telpon' => 'required'

            ])) {
                $this->output['errors'] = $validation->getErrors();
                echo json_encode($this->output);
            } else {
                $nik = $this->request->getVar('user_nik');
                $date = new Time('now');
                $rekening = $date->getTimestamp();
                $nama = $this->request->getVar('user_nama');
                $alamat = $this->request->getVar('user_alamat');
                $telpon = $this->request->getVar('user_telpon');
                $ukey = md5(uniqid($nik, true));
                $data = [
                    'nik' => $nik,
                    'ukey' => $ukey,
                    'rekening' => $rekening,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'telpon' => $telpon,
                    'status' => '1',
                    'userlogin' => null
                ];
                $simpan = $nasabah->save($data);
                if ($simpan) {
                    $saldo_model = $this->saldo_model;
                    $result = $saldo_model->saldo_baru($rekening);
                    if ($result) {
                        $this->output['success'] = true;
                        $this->output['message']  = 'Record has been updated successfully';
                        echo json_encode($this->output);
                    }
                }
            }
        }
    }

    public function view_nasabah($id)
    {
        $nasabah = $this->user_model;
        $nasabah->setTable('nasabah');
        if ($this->request->isAJAX()) {
            $result = $nasabah->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
                $myqrcode = $this->myqrcode;
                $myqrcode->setLabel($result['nik']);
                $myenc = $this->myencrypt;
                $qrcodedata = $myenc->Encrypt($result['ukey']);
                $myqrcode->CreateQrcodeToFile($qrcodedata, $result['nik']);
                $this->output['img'] = base_url('ukey/' . $result['nik'] . '.png');
                echo json_encode($this->output);
            }
        }
    }

    public function get_edit_nasabah()
    {
        $nasabah = $this->user_model;
        $nasabah->setTable('nasabah');
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('edit_user_id');
            $result = $nasabah->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
                echo json_encode($this->output);
            }
        }
    }



    public function update_data_nasabah()
    {
        $nasabah = $this->user_model;
        $nasabah->setTable('nasabah');
        $kolom = ['ukey', 'nik', 'rekening', 'nama', 'alamat', 'telpon', 'userlogin', 'status'];
        $nasabah->setAllowedFields($kolom);
        $id = $this->request->getVar('edit_user_id');
        $old_user_nik = $this->request->getVar('old_user_nik');
        $edit_user_nik = $this->request->getVar('edit_user_nik');

        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();
            if ($old_user_nik != $edit_user_nik) {
                if (!$this->validate([
                    'edit_user_nik' => 'required|is_unique[nasabah.nik]',
                    'edit_user_nama' => 'required',
                    'edit_user_alamat' => 'required',
                    'edit_user_telpon' => 'required'
                ])) {
                    $this->output['errors'] = $validation->getErrors();
                    echo json_encode($this->output);
                } else {
                    $data = [
                        'nik' => $this->request->getVar('edit_user_nik'),
                        'nama' => $this->request->getVar('edit_user_nama'),
                        'alamat' => $this->request->getVar('edit_user_alamat'),
                        'telpon' => $this->request->getVar('edit_user_telpon')
                    ];
                    $update = $nasabah->update($id, $data);
                    if ($update) {
                        $this->output['success'] = true;
                        $this->output['message']  = 'Record has been updated successfully';
                        echo json_encode($this->output);
                    }
                }
            } else {
                if (!$this->validate([
                    'edit_user_nama' => 'required',
                    'edit_user_alamat' => 'required',
                    'edit_user_telpon' => 'required'

                ])) {
                    $this->output['errors'] = $validation->getErrors();
                    echo json_encode($this->output);
                } else {
                    $data = [
                        'nama' => $this->request->getVar('edit_user_nama'),
                        'alamat' => $this->request->getVar('edit_user_alamat'),
                        'telpon' => $this->request->getVar('edit_user_telpon')
                    ];
                    $update = $nasabah->update($id, $data);
                    if ($update) {
                        $this->output['success'] = true;
                        $this->output['message']  = 'Record has been updated successfully';
                        echo json_encode($this->output);
                    }
                }
            }
        }
    }
}
