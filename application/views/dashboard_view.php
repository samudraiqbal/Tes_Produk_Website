

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    
    <!-- Button Group -->
    <div class="d-flex justify-content-between mb-4">

        <!-- Insert Produk Button -->        
        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2" data-toggle="modal" href='#susbc-form'>
            <i class="fas fa-plus fa-sm text-white-50"></i> Insert Produk
        </button>

        <!-- MODAL INSERT -->
        <div class="modal fade" id="susbc-form">
			<div class="modal-dialog shadow-lg p-3 mb-5 bg-white rounded">
				<div class="modal-content sub-bg">
					<div class="modal-header subs-header">
                    <h4 class="modal-title">Form Insert Produk</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
                                <form id="subs-form" action="<?php echo base_url('Dashboard/tambahproduk'); ?>" method="post">
                                    <div class="form-group row">
                                        <div class="col-md-12 col-xs-12">
                                            <label for="namaProduk" class="">Nama Produk </label>
                                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk" required>
                                        </div>
                                        <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                                            <label for="firstName">Harga </label>
                                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga produk" required>
                                        </div>
                                        <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                                            <label for="kategori" style="margin-top: 10px;">Kategori </label>
                                            <select class="form-control" id="kategori" name="kategori" required>
                                                <option value="" disabled selected>Silahkan pilih kategori</option>
                                                <?php foreach ($kategori as $row) : ?>
                                                    <option value="<?php echo $row->id_kategori; ?>"><?php echo $row->nama_kategori; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
                                            <label for="status" style="margin-top: 10px;">Status </label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="" disabled selected>Silahkan pilih status</option>
                                                <?php foreach ($status as $row) : ?>
                                                    <option value="<?php echo $row->id_status; ?>"><?php echo $row->nama_status; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary text-center">Add</button>
                                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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
                    <?php foreach ($status as $row) : ?>                           
                        <a class="dropdown-item" style="text-transform:capitalize" href="<?= site_url('dashboard/index?filter_status=' . $row->id_status) ?>"><?php echo $row->nama_status; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Akhir Dropdown Filter -->
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Data Produk</h6>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
