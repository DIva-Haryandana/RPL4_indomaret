<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

include ROOTPATH . '/includes/header.php';
?>

<div class="form-wrapper">
    <div class="form-card">
        <h1>Tambah Kasir</h1>
        <p class="form-subtitle">Isi data kasir baru di bawah ini</p>

        <form action="../../process/cashiers_process.php" method="post">
            <div class="input-group">
                <label for="nama_kasir">Nama Kasir</label>
                <input type="text" name="nama_kasir" id="nama_kasir" placeholder="Masukkan nama kasir" required>

                <label for="no_telp">Nomor Telepon</label>
                <input type="tel" name="no_telp" id="no_telp" placeholder="Masukan nomor telepon" required>

                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Tambah Kasir</button>
        </form>
    </div>
</div>