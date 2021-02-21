<div class="card border-primary mb-3" style="max-width: 150rem;">
    <div class="card-header">TABLE USER</div>
    <div class="card-body text-primary">
        <button class="btn btn-success btn-sm" onclick="add_user()"><i class="fa fa-plus-circle"></i>&nbsp;Tambah User</button>
        <a href="<?php echo base_url('/admin/user'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>
        <div class="col-md-12">
            <div id="message" class="hide"></div>
        </div>
        <hr>
        <table id="mytable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="90">ACTION</th>
                    <th width="5%">NO</th>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>USERTYPE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
        </table>
    </div>
</div>