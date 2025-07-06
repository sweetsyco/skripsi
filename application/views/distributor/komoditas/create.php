<div class="main-content">
<div class="page-header">
    <h1>Tambah Komoditas</h1>
    <a href="<?= site_url('distributor/komoditas') ?>" class="btn">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3>Form Tambah Komoditas</h3>
    </div>
    <div class="card-body">
        <form action="<?= site_url('distributor/komoditas/tambah') ?>" method="post">
            <div class="form-group">
                <label for="nama_komoditas">Nama Komoditas</label>
                <input type="text" class="form-control" id="nama_komoditas" name="nama_komoditas" required>
            </div>
            <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" required>
            </div><br>
            <button type="submit" class="btn btn-new">Simpan</button>
        </form>
    </div>
</div>
</div>