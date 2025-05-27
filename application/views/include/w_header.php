<?php
if($this->session->userdata('userlogin')) { 
  $users = $this->session->userdata('userlogin');
  $avatar = $this->session->userdata('avatar');
  $nama = $this->session->userdata('nama');
} else {
  $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-remove\"></i> Mohon Login terlebih dahulu</div>");
  redirect(base_url().'w_login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo get_settings('school_name'); ?></title>
    <meta content="wad Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo base_url(get_settings('favicon_path')); ?>">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/fullcalendar/vanillaCalendar.css"/>
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/metro/MetroJs.min.css">

    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/carousel/owl.theme.default.min.css">
    <link href="<?=base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/plugins/animate/animate.css" type="text/css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap-material-design.min.css" type="text/css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/icons.css" type="text/css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css">

</head>

<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="mdi mdi-close"></i>
            </button>

          <!-- LOGO -->
<div class="topbar-left">
    <div class="text-center">
        <a href="<?= base_url(); ?>dashboard" class="logo">
            <img src="<?php echo base_url(); ?>assets/images/mts7.png" alt="Logo" style="height: 40px;"> 
           
        </a>
    </div>
</div>

            <div class="sidebar-inner slimscrollleft" id="sidebar-main">

                <div id="sidebar-menu">
                    <ul>
                        <li>
                            <a href="<?=base_url();?>wad/dashboard" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?=base_url();?>wizin" class="waves-effect">
                                <i class="mdi mdi-presentation-play"></i>
                                <span> Izin </span>
                            </a>
                        </li>

                        <li>
                            <a href="<?=base_url();?>wad" class="waves-effect">
                                <i class="mdi mdi-city"></i>
                                <span> Daftar Kelas </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <div class="topbar">
                    <nav class="navbar-custom">
                        <ul class="list-inline float-right mb-0">
                            <li class="list-inline-item">
                            <h5 style="color: #ffffff;">Welcome, <?=$nama;?></h5>

                            </li>
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?=base_url();?>assets/images/<?=$avatar;?>" alt="user">
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                    <div class="dropdown-item noti-title">
                                        <h5><?=$nama;?></h5>
                                    </div>
                                    
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?=base_url();?>login/logout">
                                        <i class="mdi mdi-logout m-r-5 text-muted"></i> Logout
                                    </a>
                                </div>
                            </li>
                            
                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-left waves-light waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Top Bar End -->
