<div class="card border-primary mb-3" style="max-width: 150rem;">
    <div class="card-header"><b>TABLE NASABAH</b></div>
    <div class="card-body text-primary">
        <button class="btn btn-success btn-sm" onclick="form_tambah_nasabah()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah Nasabah</button>
        <a href="<?php echo base_url('/admin/nasabah'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>
        <div class="col-md-12">
            <div id="message" class="hide"></div>
        </div>
        <hr>
        <table id="mytable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="100">ACTION</th>
                    <th width="5%">NO</th>
                    <th>NIK</th>
                    <th>REK</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telpon</th>
                    <th>Status</th>
                    <th>Login</th>
                </tr>
            </thead>
        </table>
    </div>
</div>