<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Presensi</a></li>
                            <li class="breadcrumb-item"><a href="#">Forms</a></li>
                            <li class="breadcrumb-item active">Settings App</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Setting APP</h4>
                </div>
            </div>
        </div>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Edit Form</h4>
                        <p class="text-muted font-14">Pada Halaman Ini Administrator Bisa mengatur Tampilan</p>

                        <?php echo form_open_multipart('settings/update', ['class' => 'mb-0']); ?>
                        <div class="form-group me-2">
                                <div class="form-group me-3">
                                    <h4 class="mt-0 header-title">Logo</h4>
                                    <p class="text-muted font-14">Upload your Logo using the input below.</p>
                                    <?php if(isset($settings['logo_path']) && !empty($settings['logo_path'])): ?>
                                        <input type="file" name="logo" class="dropify" data-default-file="<?php echo base_url($settings['logo_path']); ?>" />
                                    <?php endif; ?>
                                </div>

                                <div class="form-group me-3">
                                    <h4 class="mt-0 header-title">Favicon</h4>
                                    <p class="text-muted font-14">Upload favicon website (Format: .ico atau .png)</p>
                                    <input type="file" name="favicon" class="dropify" data-default-file="<?php echo base_url($settings['favicon_path']); ?>" data-allowed-file-extensions="ico png" data-max-file-size="1M" />
                                    <small class="text-muted">Ukuran maksimal: 1MB. Format yang diizinkan: .ico, .png</small>
                                </div>

                                <div class="form-group">
                                    <h4 class="mt-0 header-title">Template Kartu E-Pelajar</h4>
                                    <p class="text-muted font-14">Upload Template (Format: .png)</p>
                                    <input type="file" name="template" class="dropify" data-default-file="<?php echo base_url($settings['path_template_card']); ?>" data-allowed-file-extensions="png" data-max-file-size="10M" />
                                    <small class="text-muted">Ukuran maksimal: 1MB. Format yang diizinkan: .png</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="app_name" class="bmd-label-floating">Name App</label>
                                <input type="text" class="form-control" id="app_name" name="app_name" value="<?php echo isset($settings['app_name']) ? $settings['app_name'] : ''; ?>">
                                <span class="bmd-help">Masukan Nama Aplikasi</span>
                            </div>

                            <div class="form-group">
                                <label for="school_name" class="bmd-label-floating">Nama Sekolah</label>
                                <input type="text" class="form-control" id="school_name" name="school_name" value="<?php echo isset($settings['school_name']) ? $settings['school_name'] : ''; ?>">
                                <span class="bmd-help">Masukan Nama Sekolah</span>
                            </div>

                            <div class="form-group">
                                <label for="phone_number" class="bmd-label-floating">No Telp</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($settings['phone_number']) ? $settings['phone_number'] : ''; ?>">
                                <span class="bmd-help">Masukan Nomor Telp Sekolah</span>
                            </div>

                            <div class="form-group">
                                <label for="address" class="bmd-label-floating">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo isset($settings['address']) ? $settings['address'] : ''; ?></textarea>
                                <span class="bmd-help">Masukan Alamat Sekolah</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-raised mb-0">Submit</button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>