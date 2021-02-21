<?= $this->extend('layout/tmpadm'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col mt-4">
            <?php if ($proses == 'user') : ?>
                <?= $this->include('user/tableuser'); ?>
            <?php endif; ?>
            <?php if ($proses == 'nasabah') : ?>
                <?= $this->include('nasabah/tabnasabah'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
<?php if ($proses == 'user') : ?>
    <?= $this->include('user/scriptuser'); ?>
<?php endif; ?>
<?php if ($proses == 'nasabah') : ?>
    <?= $this->include('nasabah/scriptnasabah'); ?>
<?php endif; ?>