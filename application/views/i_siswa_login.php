<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/mts7.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .bg-custom-purple {
            background-color: #252F75;
        }

        .text-custom-purple {
            color: #252F75;
        }

        .bg-custom-green {
            background-color: #252F75;
        }

        /* Remove any spacing around the body */
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-start justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="p-6 bg-custom-purple text-white">
                <h1 class="text-2xl font-bold">SISTEM INFORMASI ABSENSI TEPAT AKURAT</h1>
                <p class="text-xl mt-2">Silahkan Login</p>
            </div>

            <div class="p-6">
                <div class="text-center pt-3">
                    <img src="<?php echo base_url(get_settings('logo_path')); ?>" alt="logo" class="h-24 mx-auto">
                </div>

                <?php if ($this->session->flashdata('pesan')) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <?php echo $this->session->flashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url(); ?>siswal/logincheck" method="post" class="mt-4">
                    <div class="mb-4">
                        <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK:</label>
                        <input type="text" id="nik" name="nik" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan NIK">
                    </div>
                    <div class="mb-4">
                        <label for="pass" class="block text-gray-700 text-sm font-bold mb-2">NISN:</label>
                        <input type="password" id="pass" name="pass" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan NISN">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" value="true" class="form-checkbox h-5 w-5 text-custom-purple">
                            <span class="ml-2 text-gray-700">Remember me</span>
                        </label>
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="w-full bg-custom-purple text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                            Log In Siswa
                        </button>
                    </div>
                    <div class="text-center">
                        <a href="<?= base_url(); ?>/register" class="text-custom-purple hover:text-purple-700">
                            <i class="fas fa-user-plus mr-1"></i> Buat Akun Siswa
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
