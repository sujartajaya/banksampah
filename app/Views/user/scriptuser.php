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
                url: "<?php echo base_url('/admin/user_ajax_list'); ?>",
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

    function clear_error_message() {
        $('#username-error').html('');
        $('#password1-error').html('');
        $('#password2-error').html('');
        $('#email-error').html('');
        $('#usertype-error').html('');
        $('#user_username').html('');
        $('#user_email').html('');
        $('#user_usertype').html('');
        $('#user_username-error').html('');
        $('#user_email-error').html('');
        $('#user_usertype-error').html('');
        $('#user_nik-error').html('');
        $('#user_nama-error').html('');
        $('#user_alamat-error').html('');
        $('#user_telpon-error').html('');
        if ($('#user_usertypeadmin').is(':checked')) {
            $('#user_usertypeadmin').attr('checked', false);
        }
        if ($('#user_usertypeanggota').is(':checked')) {
            $('#user_usertypeanggota').attr('checked', false);
        }
    }

    function tutup_modal_tambah_user() {
        $('#ajaxTambahUSer').modal('hide');
    }

    function add_user() {
        clear_error_message();
        $('#ajaxTambahUSer').modal('show');
        $('#form-tambah-user')[0].reset();
    }

    function proses_simpan_user() {
        clear_error_message();
        $.ajax({
            url: '<?php echo base_url('admin/simpan_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-tambah-user').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.username) {
                        $('#username-error').html(res.errors.username);
                    }
                    if (res.errors.password1) {
                        $('#password1-error').html(res.errors.password1);
                    }
                    if (res.errors.password2) {
                        $('#password2-error').html(res.errors.password2);
                    }
                    if (res.errors.email) {
                        $('#email-error').html(res.errors.email);
                    }
                    if (res.errors.usertype) {
                        $('#usertype-error').html(res.errors.usertype);
                    }
                }
                if (res.success == true) {
                    clear_error_message();
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_modal_tambah_user();
                    show_record();

                }

            }
        });
    }

    function tutup_modal_tampil_data_user() {
        $('#viewModal').modal('hide');
        $('#v_username').html('');
        $('#v_email').text('');
        $('#v_usertype').html('');
        $('#v_status').html('');

    }

    function tempil_data_user(id) {

        $('#viewModal').modal('show');
        $.ajax({
            url: "<?php echo base_url('admin/tampil_data_user'); ?>" + '/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(res) {
                if (res.success == true) {
                    $('#v_username').html(res.data.username);
                    $('#v_email').text(res.data.email);
                    $('#v_usertype').html(res.data.usertype);
                    $('#v_status').html(STATUS_USER[res.data.status]);
                }
            }
        });
    }

    function tutup_modal_form_edit_user() {
        $('#ajaxEditUSer').modal('hide');
    }

    function form_edit_user(id) {
        $('#ajaxEditUSer').modal('show');
        $('#user_id').val(id);
        clear_error_message();
        $.ajax({
            url: "<?php echo base_url('admin/form_edit_user'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-edit-user').serialize(),
            success: function(res) {
                if (res.success == true) {
                    $('#user_username').val(res.data.username);
                    $('#old_user_username').val(res.data.username);
                    $('#old_user_email').val(res.data.email);
                    $('#user_email').val(res.data.email);
                    if (res.data.usertype == 'Admin') {
                        $('#user_usertypeadmin').attr('checked', true);
                    } else $('#user_usertypeanggota').attr('checked', true);
                }
            }
        });
    }

    function update_user() {
        clear_error_message();
        $.ajax({
            url: '<?php echo base_url('admin/simpan_update_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-edit-user').serialize(),
            success: function(res) {
                if (res.errors) {
                    if (res.errors.user_username) {
                        $('#user_username-error').html(res.errors.user_username);
                    }
                    if (res.errors.user_email) {
                        $('#user_email-error').html(res.errors.user_email);
                    }
                    if (res.errors.user_usertype) {
                        $('#user_usertype-error').html(res.errors.user_usertype);
                    }
                }
                if (res.success == true) {
                    $('#message').removeClass('hide');
                    $('#message').html('<div class="alert alert-success alert-dismissible">\n\
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                        <h5><i class="icon fa fa-info-circle"></i> <b>Success!</b> ' + res.message + '</h5></div>');
                    tutup_modal_form_edit_user();
                    show_record();
                }
            }
        });
    }

    function tutup_modal_activasi_user() {
        $('#ajaxActivasiUser').modal('hide');
    }

    function activasi_user(id) {
        $('#ajaxActivasiUser').modal('show');
        $('#activasi_id').val(id);
        $('#form-activasi-user')[0].reset();
        clear_error_message();
        $.ajax({
            url: "<?php echo base_url('admin/form_activasi_user'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-activasi-user').serialize(),
            success: function(res) {
                if (res.success == true) {
                    $('#user_ukey').val(res.data.ukey);
                }
            }
        });
    }

    function proses_activasi_user() {
        clear_error_message();
        $.ajax({
            url: '<?php echo base_url('admin/simpan_activasi_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-activasi-user').serialize(),
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
                    tutup_modal_activasi_user();
                    show_record();
                }
            }
        });
    }
</script>

<?= $this->endSection('jvscript'); ?>

<?= $this->section('dialogbox'); ?>
<!-- TAMBAH USER FORM -->
<div class="modal fade" id="ajaxTambahUSer" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_tambah_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-user">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required="true">
                        <span><i class="text-danger" id="username-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required="true">
                        <span><i class="text-danger" id="email-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="password1">Password1</label>
                        <input type="password" class="form-control" id="password1" name="password1" required="true">
                        <span><i class="text-danger" id="password1-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="password2">Password2</label>
                        <input type="password" class="form-control" id="password2" name="password2" required="true">
                        <span><i class="text-danger" id="password2-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="usertypeadmin" class="col-sm-2 col-form-label">Type User</label>
                        <div class="col-sm-10 mb-2">
                            <input class="form-check-input" type="radio" name="usertype" id="usertypeadmin" value="Admin">
                            <label class="form-check-label" for="usertypeadmin">
                                Admin
                            </label>
                            <input class="form-check-input" type="radio" name="usertype" id="usertypeanggota" value="Nasabah">
                            <label class="form-check-label" for="usertypeanggota">
                                Nasabah
                            </label>
                        </div>
                        <span><i class="text-danger" id="usertype-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_tambah_user()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_simpan_user()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah User</button>
            </div>
        </div>
    </div>
</div>
<!-- TAMBAH USER FORM -->

<!--View Record Modal-->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_tampil_data_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" cellspacing="0" width="100%" style="font-style: Calibri;font-size:14px;
                            border: 1px solid #ccc;">
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th width="130">Username</th>
                        <td id="v_username"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Email</th>
                        <td id="v_email"></td>
                    </tr>
                    <tr style="background: #eee;color: #4c4a4a;">
                        <th>Type User</th>
                        <td id="v_usertype"></td>
                    </tr>
                    <tr style="background: #fff;color: #4c4a4a;">
                        <th>Status</th>
                        <td id="v_status"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_tampil_data_user()"><i class=" fa fa-arrow-circle-left "></i>&nbsp;Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- !. View Record Modal-->

<!-- EDIT USER MODAL -->
<div class="modal fade" id="ajaxEditUSer" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_form_edit_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-user">
                    <div class="form-group">
                        <label for="user_username">Username</label>
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="old_user_username" name="old_user_username">
                        <input type="hidden" id="old_user_email" name="old_user_email">
                        <input type="text" class="form-control" id="user_username" name="user_username" required="true">
                        <span><i class="text-danger" id="user_username-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="text" class="form-control" id="user_email" name="user_email" required="true">
                        <span><i class="text-danger" id="user_email-error"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="user_usertypeadmin" class="col-sm-2 col-form-label">Type User</label>
                        <div class="col-sm-10 mb-2">
                            <input class="form-check-input" type="radio" name="user_usertype" id="user_usertypeadmin" value="Admin">
                            <label class="form-check-label" for="usertypeadmin">
                                Admin
                            </label>
                            <input class="form-check-input" type="radio" name="user_usertype" id="user_usertypeanggota" value="Nasabah">
                            <label class="form-check-label" for="usertypeanggota">
                                Nasabah
                            </label>
                        </div>
                        <span><i class="text-danger" id="user_usertype-error"></i></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_form_edit_user()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="update_user()"><i class="fa fa-plus-circle"></i>&nbsp;Update User</button>
            </div>
        </div>
    </div>
</div>
<!-- EDIT USER MODAL -->

<!-- FORM AKTIVASI -->
<div class="modal fade" id="ajaxActivasiUser" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">ACTIVASI NASABAH</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup_modal_activasi_user()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-activasi-user">
                    <div class="form-group">
                        <label for="user_nik">NIK</label>
                        <input type="hidden" id="activasi_id" name="activasi_id">
                        <input type="text" class="form-control" id="user_nik" name="user_nik" required="true">
                        <input type="hidden" id="user_ukey" name="user_ukey">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="tutup_modal_activasi_user()"><i class="fa fa-arrow-circle-left "></i>&nbsp;Close</button>
                <button type="button" class="btn btn-primary" onclick="proses_activasi_user()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah User</button>
            </div>
        </div>
    </div>
</div>

<!-- FORM AKTIVASI -->

<?= $this->endSection('dialogbox'); ?>