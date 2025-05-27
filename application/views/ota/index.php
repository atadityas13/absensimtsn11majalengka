<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">OTA</a></li>
                            <li class="breadcrumb-item active"> OTA Update Manager</li>
                        </ol>
                    </div>
                    <h4 class="page-title"> OTA Update Manager</h4>
                </div>
            </div>
        </div>
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Upload New Firmware</h4>
                        <p class="text-muted font-14" style="font-size: 18px; color: red; font-style: italic;">Gunakan formulir ini untuk mengunggah firmware baru. <strong>JANGAN DI OPRASIKAN JIKA TIDAK MENGERTI</strong></p>

                        <?= form_open_multipart('ota/upload') ?>
                        <form enctype="multipart/form-data">
                            <div class="form-group">
                           
                                <label for="version" class="bmd-label-floating">Version</label>
                                <input type="text" class="form-control" id="version" name="version" required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="bmd-label-floating">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="firmware" class="bmd-label-floating">Firmware File (.bin)</label>
                                <input type="file" class="form-control" id="firmware" name="firmware" accept=".bin" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-raised mb-0">Upload Firmware</button>
                        </form>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($firmware)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Latest Firmware</h4>
                        <p><strong>Version:</strong> <?= $firmware->version ?></p>
                        <p><strong>Upload Date:</strong> <?= $firmware->upload_date ?></p>
                        <p><strong>Description:</strong> <?= $firmware->description ?></p>
                        <p><strong>Filename:</strong> <?= $firmware->filename ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
