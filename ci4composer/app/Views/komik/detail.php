<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Komik</h2>
            <?php if ($komik): ?>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text"><b>Penulis : </b> <?= $komik['penulis']; ?></p>
                            <p class="card-text"><small class="text-body-secondary"><b>Penerbit : </b> <?= $komik['penerbit']; ?></small></p>
                            
                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning">Ubah</a>

                            <form action="/komik/<?= $komik['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin?');">Hapus</button>
                            </form>
                            
                            <br></br>
                            <a href="/komik">Kembali ke daftar Komik</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <p>Data komik tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
