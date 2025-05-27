<?php
$this->load->view('include/header.php');

if ($set == "list-users") {
?>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">List_User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List User</h4>
                </div>
                <a href="<?php echo base_url('users/add_users'); ?>">
                    <button type="button" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah Users</button>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php echo "<br>"; echo $this->session->flashdata('pesan'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">List User</h4>
                        <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data)) { ?>
                                    <tr>
                                        <td colspan="4">Data tidak ditemukan</td>
                                    </tr>
                                <?php } else {
                                    $no = 0;
                                    foreach ($data as $row) {
                                        $no++; ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row->nama; ?></td>
                                            <td><?php echo $row->username; ?></td>
                                            <td>
                                                <?php if ($row->id_user != 1) { ?>
                                                    <a href="<?php echo base_url('users/edit_users/' . $row->id_user); ?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                                    <a href="<?php echo base_url('users/hapus_users/' . $row->id_user); ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} elseif ($set == "add-users") {
?>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">Tambah_User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Tambah User</h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php echo "<br>"; echo $this->session->flashdata('pesan'); ?>
        <section class="section">
            <div class="row">
                <div class="col-mg-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Users</h5>
                            <?php echo form_open_multipart(base_url('users/save_users')); ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Nama Users</label>
                                    <input type="text" name="users" class="form-control" placeholder="Enter name" required>
                                </div>
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="pass" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="InputFile">Pilih Foto ("jpg", "jpeg", "gif", "png")</label>
                                    <input type="file" name="image" id="InputFile" required>
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
        </section>
    </div>
</div>
<?php
} elseif ($set == "edit-users") {
?>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">Edit_User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit User</h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php echo "<br>"; echo $this->session->flashdata('pesan'); ?>
        <section class="section">
            <div class="row">
                <div class="col-mg-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit</h5>
                            <form role="form" action="<?php echo base_url('users/save_edit_users'); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php if (isset($id)) { echo $id; } ?>">
                                    <label>Nama Users</label>
                                    <input type="text" name="users" class="form-control" value="<?php if (isset($nama)) { echo $nama; } ?>" placeholder="Enter name" required>
                                </div>
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" name="email" class="form-control" value="<?php if (isset($email)) { echo $email; } ?>" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php if (isset($username)) { echo $username; } ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <input type="password" name="pass" class="form-control" value="<?php if (isset($password)) { echo $password; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo base_url('assets/images/' . $avatar); ?>" width="auto" height="200px"><br>
                                    <input type="hidden" name="img" value="<?php if (isset($avatar)) { echo $avatar; } ?>">
                                    <label for="InputFile">Pilih Foto ("jpg", "jpeg", "gif", "png")</label>
                                    <input type="file" name="image" id="InputFile">
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
        </section>
    </div>
</div>
<?php
}
$this->load->view('include/footer.php');
?>