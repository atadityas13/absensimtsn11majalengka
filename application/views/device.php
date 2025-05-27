<!-- application/views/device/index.php -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Device Management</h3>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Device Name</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Last Seen</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($devices as $device): ?>
                            <tr>
                                <td><?= $device->id ?></td>
                                <td><?= $device->name ?></td>
                                <td><?= $device->location ?></td>
                                <td>
                                    <span class="badge badge-<?= $device->is_online ? 'success' : 'danger' ?>">
                                        <?= $device->is_online ? 'Online' : 'Offline' ?>
                                    </span>
                                </td>
                                <td><?= $device->last_seen ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" 
                                            onclick="confirmRestart(<?= $device->id ?>)">
                                        <i class="fas fa-sync"></i> Restart
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRestart(deviceId) {
    if (confirm('Are you sure you want to restart this device?')) {
        window.location.href = '<?= base_url('device/restart/') ?>' + deviceId;
    }
}
</script>