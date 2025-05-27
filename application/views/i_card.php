
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
                                <li class="breadcrumb-item active">cetak kartu</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Cetak Kartu</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Form Cetak Kartu Siswa</h4>
                            <p class="text-muted font-14" style="font-size: 18px; color: red; font-style: italic;">Hanya Digunakan Pada Saat Bulk Print Saja <strong>AKSI DI BAWAH AKAN MEMAKAN RESOURCES SERVER LEBIH BERAT</strong></p>
                            <div class="general-label">
                            <form action="<?php echo base_url('card/download_class_cards'); ?>" method="post">
                    <div class="form-group">
                        <label for="kelas">Pilih Kelas</label>
                        <select name="kelas" id="kelas" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach($classes as $class): ?>
                                <option value="<?php echo $class->id; ?>">
                                    <?php echo $class->kelas; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Download Kartu</button>
                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('include/footer.php'); ?>