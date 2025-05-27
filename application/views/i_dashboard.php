<!-- Wrapper untuk konten dashboard -->
<div class="page-content-wrapper dashborad-v">
    <div class="container-fluid">
        <!-- Header dan Breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Presensi</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
 

        <!-- Statistik Dashboard -->
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <!-- Kartu Jumlah Siswa -->
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-primary m-b-30">
                            <div class="card-body">
                                <div class="d-flex row">
                                    <div class="col-3 align-self-center">
                                        <div class="round"><i class="mdi mdi-account-card-details"></i></div>
                                    </div>
                                    <div class="col-8 ml-auto align-self-center text-center">
                                        <div class="m-l-10 text-white float-right">
                                            <h5 class="mt-0 round-inner"><?= $jmlsiswa; ?></h5>
                                            <p class="mb-0">Jumlah Siswa</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kartu Scanner -->
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-danger m-b-30">
                            <div class="card-body">
                                <div class="d-flex row">
                                    <div class="col-3 align-self-center">
                                        <div class="round"><i class="mdi mdi-home"></i></div>
                                    </div>
                                    <div class="col-8 ml-auto align-self-center text-center">
                                        <div class="m-l-10 text-white float-right">
                                            <h5 class="mt-0 round-inner"><?= $jmlkeluar; ?></h5>
                                            <p class="mb-0">Siswa Keluar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kartu Jumlah Kelas -->
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-info m-b-30">
                            <div class="card-body">
                                <div class="d-flex row">
                                    <div class="col-3 align-self-center">
                                        <div class="round"><i class="mdi mdi-school"></i></div>
                                    </div>
                                    <div class="col-8 ml-auto align-self-center text-center">
                                        <div class="m-l-10 text-white float-right">
                                            <h5 class="mt-0 round-inner"><?= count($kelas) ?></h5>
                                            <p class="mb-0">Jumlah Kelas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kartu Siswa Keluar -->
                    <div class="col-sm-12 col-md-6 col-xl-3">
                        <div class="card bg-success m-b-30">
                            <div class="card-body">
                                <div class="d-flex row">
                                    <div class="col-3 align-self-center">
                                        <div class="round"><i class="mdi mdi-ethernet"></i></div>
                                    </div>
                                    <div class="col-8 ml-auto align-self-center text-center">
                                        <div class="m-l-10 text-white float-right">
                                            <h5 class="mt-0 round-inner"><?= $jmlalat; ?></h5>
                                            <p class="mb-0">Scanner</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Statistik Dashboard -->
        <br>
        <!-- Grafik Kehadiran -->
        <div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form id="filterForm" class="row align-items-end mb-4">
                    <div class="col-md-4">
                        <label>Pilih Kelas</label>
                        <select class="form-control" name="kelas_id">
                            <option value="">Semua Kelas</option>
                            <?php foreach($kelas as $k): ?>
                                <option value="<?= $k->id ?>" <?= ($selected_class == $k->id) ? 'selected' : '' ?>>
                                    <?= $k->kelas ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Rentang Bulan</label>
                        <input type="number" class="form-control" name="months_range" 
                               value="<?= $months_range ?>" min="1">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-12 mb-4">
                        <h4 class="mt-0 header-title">
                            Kehadiran Hari Ini 
                            <?= $selected_class ? '- ' . $kelas[array_search($selected_class, array_column($kelas, 'id'))]->kelas : '' ?>
                        </h4>
                        <p class="text-muted font-14">Distribusi status kehadiran siswa.</p>
                        <div id="pie-chart"></div>
                    </div>
                    
                    <div class="col-xl-8 col-lg-6 col-md-12 mb-4">
                        <h4 class="mt-0 header-title">
                            Trend Kehadiran
                            <?= $selected_class ? '- ' . $kelas[array_search($selected_class, array_column($kelas, 'id'))]->kelas : '' ?>
                        </h4>
                        <p class="text-muted font-14">Statistik kehadiran <?= $months_range ?> bulan terakhir.</p>
                        <div id="combine-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="chart-data" value='<?= json_encode($chart_data) ?>'>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var chartData = JSON.parse(document.getElementById('chart-data').value);
    
    c3.generate({
        bindto: '#pie-chart',
        data: {
            columns: chartData.pie_chart.map(item => [item.label, item.data]),
            type: 'pie',
            colors: chartData.pie_chart.reduce((colors, item) => {
                colors[item.label] = item.color;
                return colors;
            }, {})
        },
        pie: {
            label: {
                format: (value, ratio, id) => `${value} siswa`
            }
        },
        tooltip: {
            format: {
                value: (value, ratio, id) => `${value} siswa (${(ratio * 100).toFixed(1)}%)`
            }
        }
    });
    
    c3.generate({
        bindto: '#combine-chart',
        data: {
            columns: chartData.combine_chart.series.map(series => [series.name, ...series.data]),
            types: {
                'Masuk': 'bar',
                'Izin': 'bar',
                'Sakit': 'bar',
                'Tidak Hadir': 'bar'
            },
            colors: chartData.combine_chart.series.reduce((colors, series) => {
                colors[series.name] = series.color;
                return colors;
            }, {})
        },
        axis: {
            x: { type: 'category', categories: chartData.combine_chart.months },
            y: { label: { text: 'Jumlah Siswa', position: 'outer-middle' } }
        },
        bar: { width: { ratio: 0.7 } },
        grid: { y: { show: true } }
    });
    
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        this.submit();
    });
});
</script>