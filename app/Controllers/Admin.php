<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public $user_model;

    public $output = [
        'success'   => false,
        'message'   => '',
        'data'      => []
    ];

    public function __construct()
    {
        $this->user_model = new \App\Models\UserModel;
    }

    public function index()
    {
        $data = [
            'title' => 'Admin',
            'proses' => 'home'
        ];
        return view('admin/admin_view', $data);
    }

    public function user()
    {
        $data = [
            'title' => 'Admin',
            'proses' => 'user'
        ];
        return view('admin/admin_view', $data);
    }

    public function nasabah()
    {
        $data = [
            'title' => 'Admin',
            'proses' => 'nasabah'
        ];
        return view('admin/admin_view', $data);
    }


    /**********************************************************************/
    /* TABEL USER                                                      */
    /**********************************************************************/
    public function user_ajax_list()
    {
        $user_model = $this->user_model;
        $where = ['id' != 0];
        $column_order = array('', '', 'username', 'email', 'usertype', 'status');
        $column_search = array('username', 'email', 'usertype');
        $order = array('username' => 'ASC');
        $list = $user_model->get_datatables('users', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            if ($lists->status != $this->STATUS_USER_REGISTER) {
                $classdisable = 'class="disable-link"';
            } else $classdisable = '';

            $view = '<a href="#" onclick="tempil_data_user(' . $lists->id . ') "title="View"><span style="font-size: 1em; color: Mediumslateblue;"><i class="fa fa-eye"></i></span></a>';

            $edit = '<a href="#" onclick="form_edit_user(' . $lists->id . ') "title="Edit"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-edit"></i></span></a>';

            $delete = '<a href="#" ' . $classdisable . ' onclick="delete_record(' . $lists->id . ') "title="Delete"><span style="font-size: 1em; color: Tomato;"><i class="fa fa-trash" ></i></span></a>';


            $activasi = '<a href="#" ' . $classdisable . ' onclick="activasi_user(' . $lists->id . ')" title="Activasi"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-address-card" aria-hidden="true"></i></span></a>';


            $row[]  = $view . '&nbsp;&nbsp;' . $edit . '&nbsp;&nbsp;' . $activasi . '&nbsp;&nbsp;' . $delete;
            $row[]  = $no;
            $row[]  = $lists->username;
            $row[]  = $lists->email;
            $row[]  = $lists->usertype;
            $row[]  = $this->STATUS_USER[$lists->status];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $user_model->count_all('users', $where),
            "recordsFiltered" => $user_model->count_filtered('users', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function simpan_user()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            if (!$this->validate([
                'username' => 'required|min_length[5]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password1' => 'required',
                'password2' => 'required',
                'usertype' => 'required'
            ])) {
                $this->output['errors'] = $validation->getErrors();
                echo json_encode($this->output);
            } else {
                $username = $this->request->getVar('username');
                $email = $this->request->getVar('email');
                $password1 = $this->request->getVar('password1');
                $password2 = $this->request->getVar('password2');
                $usertype = $this->request->getVar('usertype');
                $ukey = md5(uniqid($username, true));

                if ($password1 == $password2) {
                    $user = [
                        'username' => $username,
                        'ukey' => $ukey,
                        'password' => md5($password1),
                        'email' => $email,
                        'usertype' => $usertype,
                        'status' => '0'
                    ];
                    $save = $user_model->save($user);
                    if ($save) {
                        $this->output['success'] = true;
                        $this->output['message'] = 'Record has been added successfully.';
                        echo json_encode($this->output);
                    } else {
                        $this->output['errors'] = ['usertype' => 'Gagal simpan.'];
                        echo json_encode($this->output);
                    }
                } else {
                    $this->output['errors'] = ['password2' => 'Password 1 and Password 2 not matches.'];
                    echo json_encode($this->output);
                }
            }
        }
    }

    public function tampil_data_user($id)
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $result = $user_model->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
            }
            echo json_encode($this->output);
        }
    }

    public function form_edit_user()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('user_id');
            $result = $user_model->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
                echo json_encode($this->output);
            }
        }
    }

    public function form_activasi_user()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('activasi_id');
            $result = $user_model->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
                echo json_encode($this->output);
            }
        }
    }

    public function simpan_update_user()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $old_user_username = $this->request->getVar('old_user_username');
            $old_user_email = $this->request->getVar('old_user_email');
            $user_username = $this->request->getVar('user_username');
            $user_email = $this->request->getVar('user_email');
            $id = $this->request->getVar('user_id');
            if (($old_user_username == $user_username) && ($old_user_email == $user_email)) {
                $validation =  \Config\Services::validation();
                if (!$this->validate([
                    'user_usertype' => 'required'
                ])) {
                    $this->output['errors'] = $validation->getErrors();
                    echo json_encode($this->output);
                } else {
                    $data = [
                        'usertype' => $this->request->getVar('user_usertype')
                    ];
                    $update = $user_model->update($id, $data);
                    if ($update) {
                        $this->output['success'] = true;
                        $this->output['message']  = 'Record has been updated successfully';
                        echo json_encode($this->output);
                    }
                }
            } else {
                if (($old_user_username == $user_username) && ($old_user_email != $user_email)) {
                    $validation =  \Config\Services::validation();
                    if (!$this->validate([
                        'user_email' => 'required|valid_email|is_unique[users.email]',
                        'user_usertype' => 'required'
                    ])) {
                        $this->output['errors'] = $validation->getErrors();
                        echo json_encode($this->output);
                    } else {
                        $data = [
                            'email' => $this->request->getVar('user_email'),
                            'usertype' => $this->request->getVar('user_usertype')
                        ];
                        $update = $user_model->update($id, $data);
                        if ($update) {
                            $this->output['success'] = true;
                            $this->output['message']  = 'Record has been updated successfully';
                            echo json_encode($this->output);
                        }
                    }
                } else {
                    if (($old_user_username != $user_username) && ($old_user_email == $user_email)) {
                        $validation =  \Config\Services::validation();
                        if (!$this->validate([
                            'user_username' => 'required|min_length[5]|max_length[100]|is_unique[users.username]',
                            'user_usertype' => 'required'
                        ])) {
                            $this->output['errors'] = $validation->getErrors();
                            echo json_encode($this->output);
                        } else {
                            $data = [
                                'username' => $this->request->getVar('user_username'),
                                'usertype' => $this->request->getVar('user_usertype')
                            ];
                            $update = $user_model->update($id, $data);
                            if ($update) {
                                $this->output['success'] = true;
                                $this->output['message']  = 'Record has been updated successfully';
                                echo json_encode($this->output);
                            }
                        }
                    } else {
                        $validation =  \Config\Services::validation();
                        if (!$this->validate([
                            'user_username' => 'required|min_length[5]|max_length[100]|is_unique[users.username]',
                            'user_email' => 'required|valid_email|is_unique[users.email]',
                            'usertype' => 'required'
                        ])) {
                            $this->output['errors'] = $validation->getErrors();
                            echo json_encode($this->output);
                        } else {
                            $data = [
                                'username' => $this->request->getVar('user_username'),
                                'email' => $this->request->getVar('user_email'),
                                'usertype' => $this->request->getVar('user_usertype')
                            ];
                            $update = $user_model->update($id, $data);
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
    }

    public function simpan_activasi_user()
    {
        $nasabah = $this->user_model;
        $user_model = $this->user_model;

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

                // $this->output['success'] = true;
                // $this->output['message']  = $this->request->getVar('activasi_id');
                // echo json_encode($this->output);

                $nik = $this->request->getVar('user_nik');
                $nama = $this->request->getVar('user_nama');
                $ukey = $this->request->getVar('user_ukey');
                $alamat = $this->request->getVar('user_alamat');
                $telpon = $this->request->getVar('user_telpon');


                $data = [
                    'nik' => $nik,
                    'ukey' => $ukey,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'telpon' => $telpon,
                    'status' => '1'
                ];
                $kolom = ['ukey', 'nik', 'nama', 'alamat', 'telpon', 'status'];
                $nasabah->setAllowedFields($kolom);
                $nasabah->setTable('nasabah');

                $simpan = $nasabah->save($data);

                if ($simpan) {
                    $data = [
                        'status' => '1'
                    ];
                    $id = $this->request->getVar('activasi_id');
                    $update = $user_model->update($id, $data);
                    if ($update) {
                        $this->output['success'] = true;
                        $this->output['message']  = 'Record has been updated successfully';
                        echo json_encode($this->output);
                    }
                }
            }
        }
    }

    /**********************************************************************/
    /* TABEL NASABAH                                                      */
    /**********************************************************************/
}
