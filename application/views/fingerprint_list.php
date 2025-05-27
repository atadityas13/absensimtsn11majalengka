<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sidik Jari</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Sidik Jari</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pengguna</th>
                    <th>Data Sidik Jari</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($fingerprints)) : ?>
                    <?php $no = 1; foreach ($fingerprints as $fp) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $fp['user_id']; ?></td>
                            <td><code><?= base64_encode($fp['fingerprint_data']); ?></code></td>
                            <td><?= $fp['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
