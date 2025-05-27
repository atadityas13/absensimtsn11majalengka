<?php
if (!$this->session->userdata('userlogin')) { // Mencegah akses tanpa login
    $this->session->set_flashdata(
        "pesan", 
        "<div class=\"alert alert-danger\" id=\"alert\">
            <i class=\"glyphicon glyphicon-remove\"></i> Mohon Login terlebih dahulu
        </div>"
    );
    redirect(base_url().'login');
}

$users = $this->session->userdata('userlogin');
$avatar = $this->session->userdata('avatar');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= get_settings('school_name') ?></title>
    <meta name="description" content="SI ATA" />
    <meta name="author" content="Mannatthemes" />
    <link rel="shortcut icon" href="<?= base_url(get_settings('favicon_path')) ?>" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fullcalendar/vanillaCalendar.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/chartist/css/chartist.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/morris/morris.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/metro/MetroJs.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/carousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/animate/animate.css" />
    <link href="<?= base_url() ?>assets/plugins/c3/c3.min.css" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-material-design.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/icons.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" />

    <style>
        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            width: 300px;
            margin: 22px 25px 22px 20px;
        }

        #nav-search {
            width: 100%;
            padding: 8px 3px 8px 10px;
            border: none;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 14px;
        }

        #nav-search::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-button {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        .search-results {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
        }

        .search-result-item {
            padding: 10px 15px;
            cursor: pointer;
            color: #333;
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
        }
    </style>
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
        <!-- Left Sidebar -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="mdi mdi-close"></i>
            </button>

            <!-- Logo -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="<?= base_url() ?>dashboard" class="logo">
                        <img src="<?php echo base_url(get_settings('logo_path')); ?>" alt="Logo" style="height: 40px;">
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-inner slimscrollleft" id="sidebar-main">
                <div id="sidebar-menu">
                    <ul>
                        <li>
                            <a href="<?= base_url() ?>dashboard" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Data Menu -->
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-file"></i>
                                <span>Data</span>
                                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                            </a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?= base_url() ?>kelas">
                                        <i class="ti-home"></i>
                                        <span>Kelas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>walikelas/list_walikelas">
                                        <i class="mdi mdi-account-box"></i>
                                        <span>Wali Kelas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>siswa">
                                        <i class="mdi mdi-account"></i>
                                        <span>Siswa</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>card/cetak_kartu">
                                        <i class="mdi mdi-account-card-details"></i>
                                        <span>Cetak Kartu</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>siswa/siswanew">
                                        <i class="mdi mdi-access-point"></i>
                                        <span>RFID</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Absensi Menu -->
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="fa fa-calendar"></i>
                                <span>Absensi</span>
                                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                            </a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?= base_url() ?>absensi">
                                        <i class="mdi mdi-account-check"></i>
                                        <span>Riwayat Kehadiran</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>alfa">
                                        <i class="mdi mdi-account-remove"></i>
                                        <span>Alpa</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>izin">
                                        <i class="mdi mdi-hospital"></i>
                                        <span>Perizinan</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Pengaturan Menu -->
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="fa fa-cog"></i>
                                <span>Pengaturan</span>
                                <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                            </a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?= base_url() ?>users">
                                        <i class="mdi mdi-account-key"></i>
                                        <span>Admin</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>devices">
                                        <i class="mdi mdi-xaml"></i>
                                        <span>Device</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>setting">
                                        <i class="mdi mdi-camera-timer"></i>
                                        <span>Waktu Operasional</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>kelas/manage_holidays">
                                        <i class="mdi mdi-calendar-remove"></i>
                                        <span>Waktu Libur</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>sql">
                                        <i class="mdi mdi-database-plus"></i>
                                        <span>SQL Command</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>settings">
                                        <i class="mdi mdi-apps"></i>
                                        <span>APP Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>ota">
                                        <i class="mdi mdi-airplane"></i>
                                        <span>Over The Air</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-page">
            <div class="content">
                <!-- Top Bar -->
                <div class="topbar">
                    <nav class="navbar-custom">
                        <!-- Search Box -->
                        <div class="dropdown notification-list nav-pro-img">
                            <div class="list-inline-item hide-phone app-search">
                                <div role="search" class="">
                                    <div class="form-group pt-1">
                                        <input type="text" id="nav-search" placeholder="Search..">
                                        <div id="search-results" class="search-results"></div>
                                        <a href=""><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Items -->
                        <ul class="list-inline float-right mb-0 mr-3">
                            <!-- Messages -->
                            

                            <!-- User Profile -->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#">
                                    <img src="<?= base_url() ?>assets/images/<?= $this->session->userdata('avatar') ?>" alt="user">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                    <div class="dropdown-item noti-title">
                                        <h5><?= $this->session->userdata('userlogin') ?></h5>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url() ?>login/logout">
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
                        <div class="clearfix"></div>
                    </nav>
                </div>
                