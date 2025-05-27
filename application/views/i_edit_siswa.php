<?php
$this->load->view('include/header.php');?>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">siswa</a></li>
                                <li class="breadcrumb-item active">siswa Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit siswa</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Form Edit Siswa</h4>
                            <div class="general-label">
                                <form role="form" action="<?= base_url(); ?>kelas/save_edit_siswa" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <input type="hidden" name="id" value="<?php if (isset($id)) { echo $id; } ?>">

                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php if (isset($nama)) { echo $nama; } ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>NISN</label>
                                            <input type="text" name="nisn" class="form-control" placeholder="NISN" value="<?php if (isset($nisn)) { echo $nisn; } ?>" required>
                                        </div>

                                        

                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="kelas_id" class="form-control">
                                                <?php foreach ($list_kelas as $kls) { ?>
                                                    <option <?php if ($kelas != null && $kls->id == $kelas->id) { ?> selected <?php } ?> value="<?php echo $kls->id; ?>"><?php echo $kls->kelas; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?php if (isset($alamat)) { echo $alamat; } ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php if (isset($tempat_lahir)) { echo $tempat_lahir; } ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" class="form-control" value="<?php if (isset($tanggal_lahir)) { echo date('Y-m-d', strtotime($tanggal_lahir)); } ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="foto">Foto:</label>
                                            <input class="form-control" type="file" name="foto" id="foto">
                                            <small class="form-text text-muted">Upload foto Anda di sini. Biarkan kosong jika tidak ingin mengubah foto.</small>
                                            <?php if (!empty($foto)) { ?>
                                                <img src="<?= base_url(); ?>uploads/<?php echo $foto; ?>" alt="Foto Saat Ini" style="width: 100px; height: auto;">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('include/footer.php'); ?>