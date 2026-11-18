<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

include ROOTPATH . '/includes/header.php';
?>

<div class="form-wrapper">
    <div class="form-card">
        <h1>Tambah Transaksi</h1>
        <p class="form-subtitle">Isi data transaksi baru di bawah ini</p>

        <form action="../../process/transactions_process.php" method="post">
            <input type="hidden" name="action" value="add">
            <div class="input-group">
                <label for="kode_transaksi">Kode Transaksi</label>
                <input type="text" name="kode_transaksi" id="kode_transaksi" placeholder="Masukkan kode transaksi"
                    required>

                <label for="id_kasir">Kasir</label>
                <input type="number" name="id_kasir" id="id_kasir" placeholder="Masukkan ID kasir" required>

                <label for="no_order">No. Order</label>
                <input type="text" name="no_order" id="no_order" placeholder="Masukkan no. order" required>

                <label for="total">Total</label>
                <input type="number" name="total" id="total" placeholder="Masukkan total belanja" required>

                <label for="QRIS">QRIS</label>
                <input type="text" name="QRIS" id="QRIS" placeholder="Pembayaran QRIS" required>

                <label for="tunai">Tunai</label>
                <input type="number" name="tunai" id="tunai" placeholder="Pembayaran Tunai" required>

                <label for="kembalian">Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" placeholder="Kembalian" required>

                <label for="id_donasi">ID Donasi</label>
                <input type="number" name="id_donasi" id="id_donasi" placeholder="Masukkan ID donasi" required>
            </div>

            <button type="submit" class="btn-submit">Tambah Transaksi</button>
        </form>
    </div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>