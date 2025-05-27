<?php
$this->load->view('include/header.php');

if ($set=="list-walikelas") {
?>
<div class="page-content-wrapper ">

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Wali Kelas</a></li>
                        <li class="breadcrumb-item active">List_Walikelas</li>
                    </ol>
                </div>
                <h4 class="page-title">List Wali Kelas</h4>
                 </div>
                 <a href="<?php base_url()?>add_walikelas"><button type="button" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah Wali Kelas</button></a>
           
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title end breadcrumb -->
    <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">            
                    <h4 class="mt-0 header-title">List Wali Kelas</h4>
                    
                    <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                           
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if(empty($data)){?>
                <tr>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                 
                  <td>Data tidak ditemukan</td>
                  <?php } else{
                $no=0;
                foreach($data as $row){ $no++;?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $row->nama;?></td>
                 
                  <td>
                  <div class="btn-group mt-0 m-b-10">
                                                            <button type="button" class="btn btn-info btn-raised dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="<?=base_url()?>walikelas/edit_walikelas/<?=$row->id_walikelas?>">Edit Walikelas</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="<?=base_url()?>walikelas/hapus_walikelas/<?=$row->id_walikelas?>">Hapus Walikelas</a>
                                                            </div>
                                                        </div><!-- /btn-group -->
                </td>
                  
                </tr>
                <?php }}?>
                        </tbody>
                    </table>            
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->
<?php
} else if ($set=="add-walikelas") {
?>
 <div class="page-content-wrapper ">

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Wali Kelas</a></li>
                        <li class="breadcrumb-item active">Tambah_Walikelas</li>
                    </ol>
                </div>
                <h4 class="page-title">Tambah Wali Kelas</h4>
                
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title end breadcrumb -->
    <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
<section class="section">
  <div class="row">
    <div class="col-mg-auto">
    <?php echo $this->session->flashdata('pesan');?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Tambah Wali Kelas</h5>

          <!-- General Form Elements -->
          <?php echo form_open_multipart(base_url().'walikelas/save_walikelas'); ?>
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Wali Kelas</label>
                  <input type="text" name="nama" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                  <label>NUPTK</label>
                  <input type="text" name="nuptk" class="form-control" placeholder="Enter NUPTK" required>
                </div>
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="text" name="kelas" class="form-control" placeholder="Enter Kelas" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                  <label for="InputFile">Pilih Foto ("jpg", "jpeg", "gif", "png")</label>
                  <input type="file" name="image" id="InputFile" value="">
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

</main><!-- End #main -->
        <?php
} else if ($set=="edit-walikelas") {
?> <div class="page-content-wrapper ">

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Wali Kelas</a></li>
                        <li class="breadcrumb-item active">Edit_Walikelas</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Wali Kelas</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title end breadcrumb -->
    <?php echo "<br>"; echo $this->session->flashdata('pesan');?>

<section class="section">
  <div class="row">
    <div class="col-mg-auto">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit</h5>

          <!-- General Form Elements -->
          <form role="form" action="<?=base_url();?>walikelas/save_edit_walikelas" enctype="multipart/form-data" method="post" accept-charset="utf-8">
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php if(isset($id)){echo $id;}?>">
                  <label>Nama Wali Kelas</label>
                  <input type="text" name="nama" class="form-control" value="<?php if(isset($nama)){echo $nama;}?>" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                  <label>NUPTK</label>
                  <input type="text" name="nuptk" class="form-control" value="<?php if(isset($nuptk)){echo $nuptk;}?>" placeholder="Enter NUPTK" required>
                </div>
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="text" name="kelas" class="form-control" value="<?php if(isset($kelas)){echo $kelas;}?>" placeholder="Enter Kelas" required>
                </div>
                <div class="form-group">
                <img src="<?=base_url();?>components/dist/img/<?php if(isset($avatar)){echo $avatar;}?>" width="auto" height="200px"><br>
                  <input type="hidden" name="img" value="<?php if(isset($avatar)){echo $avatar;}?>">
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

</main><!-- End #main -->
<?php
} 

$this->load->view('include/footer.php');
?>
