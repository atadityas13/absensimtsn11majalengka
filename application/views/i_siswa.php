<?php if ($set == "siswa"): ?>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('siswa') ?>">Siswa</a></li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Siswa</h4>
                    </div>
                </div>
            </div>
            
            <?php if ($this->session->flashdata('pesan')): ?>
                <div class="row">
                    <div class="col-12">
                        <?= $this->session->flashdata('pesan') ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="header-title">Data Siswa</h4>
                                <div>
                                    <!-- Form to generate all cards -->
                                    <form method="post" action="<?= base_url('card/generate_cards'); ?>" style="display:inline;">
                                        <input type="hidden" name="cetak_semua" value="1">
                                        <?php if (isset($row) && isset($row->kelas)): ?>
                                            <input type="hidden" name="kelas_id" value="<?= $row->kelas ?>">
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-success">Cetak Semua Kartu</button>
                                    </form>
                                    
                                    <a href="<?= base_url('siswa/siswanew') ?>" class="btn btn-primary ml-2">
                                        <i class="fa fa-user-plus"></i> Siswa Baru
                                    </a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NISN</th>
                                            <th>UID RFID</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Alamat</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($siswa)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                            </tr>
                                        <?php else: 
                                            $no = 0;
                                            foreach ($siswa as $item):
                                                if (!empty($item->nama)):
                                                    $no++;
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $item->nisn; ?></td>
                                                    <td><?= $item->uid; ?></td>
                                                    <td><?= $item->nama; ?></td>
                                                    <td><?= $item->kelas; ?></td>
                                                    <td><?= $item->alamat; ?></td>
                                                    
                                                    
                                            <td>
                                                <div class="btn-group mt-0 m-b-10">
                                                    <button type="button" class="btn btn-info btn-raised dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url(); ?>siswa/detail_murid/<?= $item->id_siswa; ?>">Detail Siswa</a>
                                                        <a class="dropdown-item" href="<?= base_url('siswa/edit_siswa/' . $item->id_siswa) ?>">Edit Siswa</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="<?= base_url('siswa/delete_siswa/' . $item->id_siswa) ?>">Hapus Siswa</a>
                                                    </div>
                                                </div>
                                            </td>

                                                </tr>
                                        <?php 
                                                endif;
                                            endforeach;
                                        endif; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($set == "edit-siswa"): ?>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('siswa') ?>">Siswa</a></li>
                                <li class="breadcrumb-item active">Edit Siswa</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Siswa</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="header-title">Form Edit Siswa</h4>
                                <a href="<?= base_url('siswa') ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            
                            <div class="general-label">
                                <?= form_open_multipart('siswa/save_edit_siswa', ['class' => 'form-horizontal']); ?>
                                    <div class="box-body">
                                        <input type="hidden" name="id" value="<?= isset($id_siswa) ? $id_siswa : ''; ?>">
                                        <input type="hidden" name="old_foto" value="<?= isset($foto) ? $foto : ''; ?>">

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama" class="form-control" placeholder="Nama" 
                                                       value="<?= isset($nama) ? $nama : ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">NISN</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nisn" class="form-control" placeholder="NISN" 
                                                       value="<?= isset($nisn) ? $nisn : ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Kelas</label>
                                            <div class="col-sm-10">
                                                <select name="kelas_id" class="form-control">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    <?php foreach ($list_kelas as $kls): ?>
                                                        <option value="<?= $kls->id; ?>" 
                                                            <?= (isset($kelas) && $kls->id == $kelas->id) ? 'selected' : ''; ?>>
                                                            <?= $kls->kelas; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat" required><?= isset($alamat) ? $alamat : ''; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Tempat Lahir</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" 
                                                       value="<?= isset($tempat_lahir) ? $tempat_lahir : ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Tanggal Lahir</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="tanggal_lahir" class="form-control" 
                                                       value="<?= isset($tanggal_lahir) ? date('Y-m-d', strtotime($tanggal_lahir)) : ''; ?>" 
                                                       required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Foto</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="foto" id="foto">
                                                <small class="form-text text-muted">Upload foto siswa (JPG, PNG, GIF). Biarkan kosong jika tidak ingin mengubah foto.</small>
                                                
                                                <?php if (!empty($foto)): ?>
                                                    <div class="mt-2">
                                                        <p>Foto Saat Ini:</p>
                                                        <img src="<?= base_url('uploads/' . $foto); ?>" alt="Foto Saat Ini" 
                                                             class="img-thumbnail" style="max-width: 150px; height: auto;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Simpan
                                            </button>
                                            <a href="<?= base_url('siswa'); ?>" class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Batal
                                            </a>
                                        </div>
                                    </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($set == "new"): ?>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('siswa') ?>">Siswa</a></li>
                                <li class="breadcrumb-item active">Siswa Baru</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Siswa Baru</h4>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="header-title">Daftar Siswa Baru</h4>
                                <div>
                                    <a href="<?= current_url(); ?>" class="btn btn-info">
                                        <i class="fa fa-refresh"></i> Perbarui
                                    </a>
                                    <a href="<?= base_url('siswa'); ?>" class="btn btn-secondary ml-2">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>UID Siswa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($siswa)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Siswa baru tidak ditemukan</td>
                                            </tr>
                                        <?php else: 
                                            $no = 0;
                                            foreach ($siswa as $row):
                                                if (empty($row->nama) || empty($row->kelas)):
                                                    $no++;
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row->uid; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('siswa/edit_siswa/' . $row->id_siswa) ?>" 
                                                           class="btn btn-info btn-sm">
                                                            <i class="fa fa-pencil"></i> Daftarkan Siswa
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php 
                                                endif;
                                            endforeach;
                                        endif; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>