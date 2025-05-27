<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Daftar</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/gi.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .bg-custom-purple {
            background-color: #252F75;
        }

        .text-custom-purple {
            color: #252F75;
        }

        body {
            margin: 0;
            padding: 0;
        }

        @media (max-width: 640px) {
            .sm\:text-sm {
                font-size: 0.875rem;
            }
            .sm\:p-4 {
                padding: 1rem;
            }
            .sm\:mb-2 {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-2 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="p-6 sm:p-4 bg-custom-purple text-white">
                <h1 class="text-2xl sm:text-xl font-bold"><?php echo get_settings('app_name'); ?></h1>
                <p class="text-xl sm:text-lg mt-2">Silahkan Daftar</p>
            </div>

            <div class="p-6 sm:p-4">
                <div class="text-center pt-3 pb-4">
                    <img src="<?php echo base_url(get_settings('logo_path')); ?>" alt="logo" class="h-20 mx-auto">
                </div>

                <?php if ($is_success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        Registrasi Berhasil! Terima kasih telah mendaftar.
                    </div>
                <?php else: ?>
                    <?php if (isset($upload_error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <?= $upload_error ?>
                        </div>
                    <?php endif; ?>
                    <?php echo validation_errors(); ?>
                    <?php echo form_open_multipart('register/submit', ['class' => 'mt-4']); ?>
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Nama:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nama" id="nama" required placeholder="Contoh: IMAM DIENUL BAYAN">
                            </div>
                            <div>
                                <label for="tempat" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Tempat Lahir:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="tempat" id="tempat" required placeholder="Contoh: Majalengka">
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Tanggal Lahir:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" name="tanggal_lahir" id="tanggal_lahir" required>
                            </div>
                            <div>
                                <label for="kelas" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Kelas:</label>
                                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="kelas" name="id_kelas">
                                    <option value="">--Pilih Kelas--</option>
                                    <?php foreach ($kelas as $row): ?>
                                        <option value="<?= $row->id ?>"><?= $row->kelas ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="nisn" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">NISN:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="nisn" id="nisn" required placeholder="Contoh: 1212838392">
                            </div>
                            
                            <div>
                                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Alamat:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="alamat" id="alamat" required placeholder="Contoh: Desa Cibeureum, Kec. Talaga, Kab. Majalengka">
                            </div>
                            <div>
                                <label for="foto" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-1">Foto:</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="foto" id="foto" required>
                                <small class="text-gray-500 text-xs">Upload foto Anda di sini</small>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="w-full bg-custom-purple text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline" type="submit">Daftar</button>
                        </div>
                    <?php echo form_close(); ?>
                <?php endif; ?>
                <div class="text-center mt-4">
                    <a href="<?= base_url(); ?>siswal" class="text-custom-purple hover:text-purple-700 text-sm">
                        <i class="fas fa-sign-in-alt mr-1"></i> Sudah punya akun?
                    </a>
                </div>
            </div>
        </div>
    </div>


    
</body>

</html>


