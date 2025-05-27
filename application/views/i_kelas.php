<?php
$this->load->view('include/header.php');
?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Kelas</a></li>
                            <li class="breadcrumb-item active">Kelas_list</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Class List</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Add Kelas</h4>
                        <form action="" method="POST">
                            <div class="form-row align-items-center">
                                <div class="col-4">
                                    <label class="sr-only" for="inlineFormInputGroup">Nama Kelas</label>
                                    <div class="input-group">
                                        <input type="text" name="kelas" required placeholder="Nama Kelas" class="form-control">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Class List</h4>
                        <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Murid</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($kelas)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($kelas as $row): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><b class="text-primary"><?php echo $row->kelas; ?></b></td>
                                            <?php $jumlah_murid = $m_data->count_murid($row->id); ?>
                                            <td><?php echo $jumlah_murid; ?></td>
                                            <td>
                                                <div class="btn-group mt-0 m-b-10">
                                                    <button type="button" class="btn btn-info btn-raised dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="kelas/lihat_kelas?id_kelas=<?= $row->id; ?>">Lihat Kelas</a>
                                                        <a class="dropdown-item" href="<?= base_url() ?>/kelas/rekap_absen/<?= $row->id; ?>">Rekap Absensi</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="<?= site_url() ?>/kelas/hapus_kelas?id_kelas=<?= $row->id; ?>">Hapus Kelas</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('include/footer.php');
?>
