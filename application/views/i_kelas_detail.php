<?php $this->load->view('include/header.php'); ?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Daftar Kelas</a></li>
                            <li class="breadcrumb-item active"><?= isset($kelas->kelas) ? $kelas->kelas : 'Detail Kelas'; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Detail Kelas</h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mt-0 header-title">Data Murid Kelas: <?= isset($kelas->kelas) ? $kelas->kelas : '-'; ?></h4>
                            <div>
                                <?php if(isset($kelas->id)): ?>
                                    <a href="<?= base_url(); ?>kelas/rekap_absen/<?= $kelas->id; ?>" class="btn btn-primary">Rekap Absen</a>
                                    <form method="post" action="<?= base_url('card/generate_cards'); ?>" style="display:inline;">
                                        <input type="hidden" name="cetak_semua" value="1">
                                        <input type="hidden" name="kelas_id" value="<?= $kelas->id ?>">
                                        <button type="submit" class="btn btn-success">Cetak Semua Kartu</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Kode Presensi Manual</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($murid)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    $no = 1;
                                    foreach ($murid as $row): 
                                        if (!empty($row->nama)): 
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->nama; ?></td>
                                            <td><?= $row->kelas; ?></td>
                                            <td><?= $row->id_siswa; ?></td>
                                            <td>
                                                <img src="<?= base_url(); ?>uploads/<?= $row->foto; ?>" class="img-circle" width="auto" height="80px" alt="Foto Murid">
                                            </td>
                                            <td>
                                                <a href="<?= base_url(); ?>kelas/detail_murid/<?= $row->id_siswa; ?>" class="btn btn-success btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url(); ?>kelas/hapus_murid/<?= $row->id_siswa; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus murid ini?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('include/footer.php'); ?>