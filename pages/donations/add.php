<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

include ROOTPATH . '/includes/header.php';
?>

<div class="form-wrapper">
    <div class="form-card">
        <h1>Tambah Donasi</h1>
        <p class="form-subtitle">Isi data donasi baru di bawah ini</p>

        <form action="../../process/donations_process.php" method="post">
            <input type="hidden" name="action" value="add">
            <div class="input-group">
                <label for="nama_donasi">Nama Donasi</label>
                <input type="text" name="nama_donasi" id="nama_donasi" placeholder="Masukkan nama donasi" required>

                <label for="harga_donasi">Harga Donasi</label>
                <input type="number" name="harga_donasi" id="harga_donasi" placeholder="Masukkan jumlah donasi"
                    required>
            </div>

            <button type="submit" class="btn-submit">Tambah Donasi</button>
    </div>


    </form>
</div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>