<?php $this->load->view('include/header.php'); ?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <!-- Page title and breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Daftar Kelas</a></li>
                            <li class="breadcrumb-item active">Detail Murid</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Detail Murid</h4>
                </div>
            </div>
        </div>
        <!-- End page title and breadcrumb -->

        <div class="row">
            <!-- Details column -->
            <div class="col-md-9 col-xl-9">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h1 class="mt-0 header-title d-flex justify-content-between align-items-center">
                            <?= $murid->nama; ?>
                            <a href="<?= base_url() ?>/kelas/edit_siswa/<?= $murid->id_siswa ?>" class="btn btn-info btn-sm">
                                Edit <i class="fa fa-pencil"></i>
                            </a>
                        </h1>
                        <div class="text-center mb-3">
                            <img src="<?= base_url(); ?>./uploads/<?= $murid->foto; ?>" class="img-circle" width="auto" height="100px" alt="User Image">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row">NISN:</th>
                                        <td><?= $murid->nisn; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NIK:</th>
                                        <td><?= $murid->nik; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tempat, Tanggal Lahir:</th>
                                        <td><?=$murid->tempat_lahir . ", " . $murid->tanggal_lahir; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kelas:</th>
                                        <td><?= $murid->kelas; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Alamat:</th>
                                        <td><?= $murid->alamat; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End details column -->
        </div>
        <!-- End murid details and photos -->

        <div class="text-center">
            <h4 class="header-title" style="margin-bottom: 20px; text-transform: uppercase;">Kartu Siswa</h4>
        </div>
        <div class="text-center">
            <!-- Kartu dengan ukuran standar KTP -->
            <div class="card kartu-siswa">
                <!-- Barcode NISN -->
                <div class="barcode">
                    <img src="data:image/png;base64,<?= $barcode; ?>" alt="Barcode">
                </div>
                
                <!-- Foto Murid -->
                <div class="photo" style="background-image: url('<?= base_url('uploads/'.$murid->foto); ?>');"></div>
                
                <!-- Detail Murid -->
                <div class="details">
                    <table>
                        <tr>
                            <th><strong>Nama</strong></th>
                            <td><strong>: <?= $murid->nama; ?></strong></td>
                        </tr>
                        <tr>
                            <th><strong>TTL</strong></th>
                            <td><strong>: <?= $murid->tempat_lahir . ", " . $murid->tanggal_lahir; ?></strong></td>
                        </tr>
                       
                        <tr>
                            <th><strong>NISN</strong></th>
                            <td><strong>: <?= $murid->nisn; ?></strong></td>
                        </tr>
                        <tr>
                            <th><strong>Alamat</strong></th>
                            <td><strong>: <?= $murid->alamat; ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Kartu Siswa Section -->
    </div>
</div>

<style>
    .page-content-wrapper {
        max-height: 100vh;
        overflow-y: auto;
        padding: 10px;
        margin-top: 70px;
    }

    .card.kartu-siswa {
        position: relative;
        width: 85.6mm;
        height: 54mm;
        background-image: url('<?php echo base_url(get_settings('path_template_card')); ?>');
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        border: 2px solid #000;
        box-sizing: border-box;
        margin: 0 auto;
        page-break-inside: avoid;
    }

    .barcode {
        position: absolute;
        top: 68px;
        left: 10px;
        width: 120px;
        height: 30px;
    }

    .barcode img {
        width: 100%;
        height: auto;
    }

    .photo {
        position: absolute;
        top: 95px;
        left: 23px;
        width: 60px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 5px;
        border: 2px solid #fff;
    }

    .details {
        position: absolute;
        top: 99px;
        left: 100px;
        color: black;
        text-align: left;
        font-family: Arial, sans-serif;
        text-transform: uppercase;
        line-height: 1;
    }

    .details table {
        border-collapse: collapse;
        width: 100%;
    }

    .details th, .details td {
        padding: 2px;
        text-align: left;
        font-size: 8px;
    }

    .details th {
        font-weight: bold;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .page-content-wrapper {
            width: 100%;
            height: 100%;
            overflow-y: visible;
        }

        .card.kartu-siswa {
            page-break-inside: avoid;
            margin-bottom: 0px;
            background-image: url('<?= base_url('assets/images/template.png'); ?>') !important;
            background-size: cover;
            background-position: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .photo {
            background-image: url('<?= base_url('uploads/'.$murid->foto); ?>') !important;
            background-size: cover;
            background-position: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page {
            margin: 0;
        }
    }
</style>

<?php $this->load->view('include/footer.php'); ?>
