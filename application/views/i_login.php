<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Modern Dashboard</title>
    <link rel="shortcut icon" href="<?php echo base_url(get_settings('favicon_path')); ?>">
    
    <!-- Modern CSS Framework -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Custom Google Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #EBF4FF 0%, #E1EFFE 100%);
            min-height: 100vh;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #60A5FA;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="glass-effect rounded-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="<?php echo base_url(get_settings('logo_path')); ?>" alt="logo" class="h-24 mx-auto mb-2">
            </div>

            <!-- Login Form -->
            <form action="<?=base_url();?>login/logincheck" method="post" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-user text-gray-400"></i>
                        </span>
                        <input name="username" type="text" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="Enter your username">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input name="pass" type="password" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="Enter your password">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="rememberMe" class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                    <label for="rememberMe" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <div class="space-y-4">
                    <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                        Login as Administrator
                    </button>
                    <a href="<?=base_url();?>/log" class="btn-primary block text-center w-full py-3 px-4 rounded-lg text-white font-medium">
                        Login as Walikelas
                    </a>
                </div>

                <div class="mt-6 text-center">
                    <a href="<?=base_url();?>/register" class="text-blue-500 hover:text-blue-600 text-sm flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Student Account
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>