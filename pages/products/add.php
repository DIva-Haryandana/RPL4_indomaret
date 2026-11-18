<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

include ROOTPATH . '/includes/header.php';
?>

<div class="form-wrapper">
    <div class="form-card">
        <h1>Tambah Produk</h1>
        <p class="form-subtitle">Isi data produk baru di bawah ini</p>

        <form action="../../process/products_process.php" method="post">
            <input type="hidden" name="action" value="add">
            <div class="input-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk" required>

                <label for="harga">Harga Produk</label>
                <input type="number" name="harga" id="harga" placeholder="Masukkan harga produk" required>

                <label for="diskon">Diskon</label>
                <input type="number" name="diskon" id="diskon" placeholder="Masukkan diskon" required>
            </div>

            <button type="submit" class="btn-submit">Tambah Produk</button>
        </form>
    </div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>