

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    
    <!-- Button Group -->
    <div class="d-flex justify-content-between mb-4">

        <!-- Insert Produk Button -->        
        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Insert Produk
        </button>

        <!-- Group for Get Data Button and Dropdown -->
        <div class="d-flex">
            <!-- Get Data From API Button -->
            <div class="d-inline-flex">
                    <form action="<?= base_url('dashboard/fetchData') ?>" method="post">
                        <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2"><i
                                class="fas fa-download fa-sm text-white-50"></i> Get Data From API</button>
                    </form>
            </div>

            <!-- Dropdown Filter -->
            <div class="dropdown d-inline-block">
                <button class="d-none d-sm-inline-block btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownFilterButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter by Status
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFilterButton">
                    <a class="dropdown-item" href="<?= site_url('dashboard/index') ?>">Semua</a>
                    <a class="dropdown-item" href="<?= site_url('dashboard/index?filter_status=1') ?>">Bisa dijual</a>
                    <a class="dropdown-item" href="<?= site_url('dashboard/index?filter_status=2') ?>">Tidak bisa dijual</a>
                </div>
            </div>
        </div>
        <!-- Akhir Dropdown Filter -->
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($produkData as $produk): ?>
                            <tr>
                                <td class="center-button">
                                    <a href="#" class="btn btn-success btn-circle btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                                <td class="center-button">
                                    <a href="#" class="btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td><?= $produk->nama_produk ?></td>
                                <td class="text-right"><?= number_format($produk->harga, 0, ',', '.'); ?></td>
                                <td><?= $produk->nama_kategori ?></td>
                                <td><?= $produk->nama_status ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- <tr>
                            <td class="center-button">
                                <a href="#" class="btn btn-success btn-circle btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                            <td class="center-button">
                                <a href="#" class="btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td>ALCOHOL GEL POLISH CLEANSER GP-CLN01</td>
                            <td>12500.00</td>
                            <td>L QUEENLY</td>
                            <td>bisa dijual</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
