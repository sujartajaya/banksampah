<?= $this->section('jvscript'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    let STATUS_USER = [
        'Belum aktif',
        'Aktif',
        'Blockir',
        'Berhenti'
    ];
    $(document).ready(function() {
        show_record();
    });

    function show_record() {
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
            bDestroy: true,
            responsive: true,
            order: [],
            ajax: {
                url: "<?php echo base_url('/nasabah/nasabah_ajax_list'); ?>",
                type: "POST",
                data: {},
            },
            columnDefs: [{
                    targets: [0, 1],
                    orderable: false,
                },
                {
                    width: "1%",
                    targets: [1, -1],
                },
                {
                    className: "dt-nowrap",
                    targets: [-1],
                }
            ],
        });
    }

    function clear_error_messages() {
        $('#user_nik-error').html('');
        $('#user_nama-error').html('');
        $('#user_alamat-error').html('');
        $('#user_telpon-error').html('');
        $('#edit_user_nik-error').html('');
        $('#edit_user_nama-error').html('');
        $('#edit_user_alamat-error').html('');
        $('#edit_user_telpon-error').html('');
        $('#user_login_username-error').html('');
        $('#user_login_password-error').html('');
        $('#user_login_email-error').html('');
    }

    function tutup_form_tambah_nasabah() {
        $('#ajaxTambahNasabah').modal('hide');
    }

    function form_tambah_nasabah() {
        clear_error_messages();
        $('#ajaxTambahNasabah').modal('show');
        $('#form-tambah-nasabah')[0].reset();
    }

    function proses_daftar_nasabah() {
        clear_error_messages();
        $.ajax({
            url: '<?php echo base_url('/nasabah/simpan_nasabah_baru'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-tambah-nasabah').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.user_nik) {
                        $('#user_nik-error').html(res.errors.user_nik);
                    }
                    if (res.errors.user_nama) {
                        $('#user_nama-error').html(res.errors.user_nama);
                    }
                    if (res.errors.user_alamat) {
                        $('#user_alamat-error').html(res.errors.user_alamat);
                    }
                    if (res.errors.user_telpon) {
                        $('#user_telpon-error').html(res.errors.user_telpon);
                    }
                }
                if (res.success == true) {
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_form_tambah_nasabah();
                    show_record();
                }
            }
        });
    }

    function close_v_modal() {
        $('#viewModal').modal('hide');
    }

    function tampil_data_nasabah(id) {
        $('#viewModal').modal('show');
        $.ajax({
            url: "<?php echo base_url('nasabah/view_nasabah'); ?>" + '/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(res) {
                if (res.success == true) {
                    $('#v_nik').html(res.data.nik);
                    $('#v_nama').html(res.data.nama);
                    $('#v_alamat').html(res.data.alamat);
                    $('#v_telpon').html(res.data.telpon);
                    $('#v_status').html(STATUS_USER[res.data.status]);
                    //alert(res.img);
                    $('#qrimage').attr('src', res.img);
                }
            }
        });
    }

    function tutup_form_edit_nasabah() {
        $('#ajaxEditNasabah').modal('hide');
    }

    function form_edit_nasabah(id) {
        $('#ajaxEditNasabah').modal('show');
        clear_error_messages();
        $('#edit_user_id').val(id);
        //alert(id);
        $.ajax({
            url: "<?php echo base_url('nasabah/get_edit_nasabah'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                edit_user_id: id
            },
            success: function(res) {
                if (res.success == true) {
                    //alert(red.data.id);
                    $('#edit_user_nik').val(res.data.nik);
                    $('#edit_user_nama').val(res.data.nama);
                    $('#edit_user_alamat').val(res.data.alamat);
                    $('#edit_user_telpon').val(res.data.telpon);
                    $('#old_user_nik').val(res.data.nik);
                }
            }
        });
    }

    function proses_edit_nasabah() {
        clear_error_messages();
        $.ajax({
            url: '<?php echo base_url('/nasabah/update_data_nasabah'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-edit-nasabah').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.edit_user_nik) {
                        $('#edit_user_nik-error').html(res.errors.edit_user_nik);
                    }
                    if (res.errors.edit_user_nama) {
                        $('#edit_user_nama-error').html(res.errors.edit_user_nama);
                    }
                    if (res.errors.edit_user_alamat) {
                        $('#edit_user_alamat-error').html(res.errors.edit_user_alamat);
                    }
                    if (res.errors.edit_user_telpon) {
                        $('#edit_user_telpon-error').html(res.errors.edit_user_telpon);
                    }
                }
                if (res.success == true) {
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_form_edit_nasabah();
                    show_record();
                }
            }
        });
    }

    function tutup_form_user_login() {
        $('#ajaxAddUserLogin').modal('hide');
    }

    function form_user_login(id) {
        clear_error_messages();
        $('#ajaxAddUserLogin').modal('show');
        $('#form-user-login-nasabah')[0].reset();
        $.ajax({
            url: "<?php echo base_url('nasabah/get_edit_nasabah'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                edit_user_id: id
            },
            success: function(res) {
                if (res.success == true) {
                    //alert(red.data.id);
                    $('#user_login_id').val(res.data.id);
                    $('#user_login_ukey').val(res.data.ukey);
                    $('#user_login_nama').html(res.data.nama);
                }
            }
        });
    }

    function proses_tambah_user_login() {
        clear_error_messages();
        $.ajax({
            url: '<?php echo base_url('userlogin/tambah_userlogin_baru'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-user-login-nasabah').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.user_login_username) {
                        $('#user_login_username-error').html(res.errors.user_login_username);
                    }
                    if (res.errors.user_login_email) {
                        $('#user_login_email-error').html(res.errors.user_login_email);
                    }
                    if (res.errors.user_login_password) {
                        $('#user_login_password-error').html(res.errors.user_login_password);
                    }

                }
                if (res.success == true) {
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_form_user_login();
                    show_record();
                }
            }

        });
    }
</script>

<?= $this->endSection('jvscript'); ?>
<!-- FORM TAMBAH NASABAH -->
<?= $this->section('dialogbox'); ?>
<div class="modal fade" id="ajaxTambahNasabah" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">FORM PENDAFTARAN NASABAH</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_form_tambah_nasabah()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-nasabah">
                    <div class="form-group">
                        <label for="user_nik">NIK</label>
                        <input type="text" class="form-control" id="user_nik" name="user_nik" required="true">
                        <span><i class="text-danger" id="user_nik-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_nama">Nama</label>
                        <input type="text" class="form-control" id="user_nama" name="user_nama" required="true">
                        <span><i class="text-danger" id="user_nama-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_alamat">Alamat</label>
                        <input type="text" class="form-control" id="user_alamat" name="user_alamat" required="true">
                        <span><i class="text-danger" id="user_alamat-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_telpon">Telpon</label>
                        <input type="user_telpon" class="form-control" id="user_telpon" name="user_telpon" required="true">
                        <span><i class="text-danger" id="user_telpon-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_form_tambah_nasabah()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_daftar_nasabah()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah User</button>
            </div>
        </div>
    </div>
</div>
<!-- FORM TAMBAH NASABAH -->
<!--View Record Modal-->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Data Nasabah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_v_modal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" cellspacing="0" width="100%" style="font-style: Calibri;font-size:14px;
                            border: 1px solid #ccc;">
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th width="130">NIK</th>
                        <td id="v_nik"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Nama</th>
                        <td id="v_nama"></td>
                    </tr>
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th>Alamat</th>
                        <td id="v_alamat"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Telpon</th>
                        <td id="v_telpon"></td>
                    </tr>
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th>Status</th>
                        <td id="v_status"></td>
                    </tr>
                </table>
                <div class="card" style="width: 18rem;">
                    <img id="qrimage" src="..." class="card-img-top" alt="...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_v_modal()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
            </div>
        </div>
    </div>
</div>
<!-- !. View Record Modal-->

<!-- Edit Nasabah -->
<div class="modal fade" id="ajaxEditNasabah" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">FORM EDIT NASABAH</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_form_edit_nasabah()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-nasabah">
                    <div class="form-group">
                        <label for="edit_user_nik">NIK</label>
                        <input type="hidden" id="edit_user_id" name="edit_user_id">
                        <input type="hidden" id="old_user_nik" name="old_user_nik">
                        <input type="text" class="form-control" id="edit_user_nik" name="edit_user_nik" required="true">
                        <span><i class="text-danger" id="edit_user_nik-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_nama">Nama</label>
                        <input type="text" class="form-control" id="edit_user_nama" name="edit_user_nama" required="true">
                        <span><i class="text-danger" id="edit_user_nama-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_alamat">Alamat</label>
                        <input type="text" class="form-control" id="edit_user_alamat" name="edit_user_alamat" required="true">
                        <span><i class="text-danger" id="edit_user_alamat-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_user_telpon">Telpon</label>
                        <input type="user_telpon" class="form-control" id="edit_user_telpon" name="edit_user_telpon" required="true">
                        <span><i class="text-danger" id="edit_user_telpon-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_form_edit_nasabah()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_edit_nasabah()"><i class="fa fa-plus-circle"></i>&nbsp;Edit Nasabah</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Nasabah -->

<!-- Add user login -->
<div class="modal fade" id="ajaxAddUserLogin" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">
                    <div id="user_login_nama"></div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_form_user_login()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-user-login-nasabah">
                    <div class="form-group">
                        <label for="edit_user_nik">Username</label>
                        <input type="hidden" id="user_login_id" name="user_login_id">
                        <input type="hidden" id="user_login_nik" name="user_login_nik">
                        <input type="hidden" id="user_login_ukey" name="user_login_ukey">
                        <input type="text" class="form-control" id="user_login_username" name="user_login_username" required="true">
                        <span><i class="text-danger" id="user_login_username-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_login_password">Password</label>
                        <input type="text" class="form-control" id="user_login_password" name="user_login_password" required="true">
                        <span><i class="text-danger" id="user_login_password-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_login_email">Email</label>
                        <input type="text" class="form-control" id="user_login_email" name="user_login_email" required="true">
                        <span><i class="text-danger" id="user_login_email-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_form_user_login()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_tambah_user_login()"><i class="fa fa-plus-circle"></i>&nbsp;Aktifasi User Login</button>
            </div>
        </div>
    </div>
</div>
<!-- Add user login -->


<?= $this->endSection('dialogbox'); ?>