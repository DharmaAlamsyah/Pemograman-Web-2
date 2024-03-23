<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Hubungi Kami</h2>
            <?php foreach ($alamat as $a) : ?>
                <li><?= $a ?></li>
            <?php endforeach; ?>
            <br>
            <?php foreach ($alamat1 as $a) : ?>
                <li><?= $a ?></li>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>