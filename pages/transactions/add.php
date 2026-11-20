<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');
include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$produk = mysqli_query($connection, "SELECT * FROM produk");
$daftar_produk = [];
while ($row = mysqli_fetch_assoc($produk)) {
    $daftar_produk[] = $row;
}
?>

<div class="form-wrapper">
    <div class="form-card" style="max-width: 560px;">
        <h1>Tambah Transaksi</h1>
        <p class="form-subtitle">Isi data transaksi baru di bawah ini</p>

        <form action="/indo_rpl/process/transactions_process.php" method="post">
            <input type="hidden" name="action" value="add">

            <!-- Data utama -->
            <div class="input-group">
                <label>Kode Transaksi</label>
                <input type="text" name="kode_transaksi" required>

                <label>ID Kasir</label>
                <input type="number" name="id_kasir" required>

                <label>No. Order</label>
                <input type="text" name="no_order" required>
            </div>

            <hr style="border-color: rgba(255,255,255,0.3); margin: 20px 0;">
            <h3 style="margin-bottom: 10px;">Detail Produk</h3>

            <div id="produk-list">
                <div class="produk-item input-group">
                    <label>Produk</label>
                    <select name="id_produk[]" class="select-produk" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php foreach ($daftar_produk as $p) { ?>
                        <option value="<?php echo $p['id_produk']; ?>" data-harga="<?php echo $p['harga']; ?>"
                            data-diskon="<?php echo $p['diskon']; ?>">
                            <?php echo htmlspecialchars($p['nama_produk']); ?>
                        </option>
                        <?php } ?>
                    </select>

                    <label>Kuantitas</label>
                    <input type="number" name="kuantitas[]" class="input-qty" min="1" value="1" required>

                    <label>Harga</label>
                    <input type="number" name="harga[]" class="input-harga" readonly required>

                    <label>Diskon</label>
                    <input type="number" name="diskon[]" class="input-diskon" readonly required>
                </div>
            </div>

            <button type="button" class="btn-submit" id="btn-tambah-produk" style="margin-top: 10px;">
                + Tambah Produk
            </button>

            <hr style="border-color: rgba(255,255,255,0.3); margin: 20px 0;">

            <!-- Pembayaran di bawah -->
            <div class="input-group">
                <label>Total Belanja</label>
                <input type="number" name="total" id="total" readonly required>

                <label>QRIS</label>
                <input type="number" name="QRIS" id="QRIS" value="0" required>

                <label>Tunai</label>
                <input type="number" name="tunai" id="tunai" value="0" required>

                <label>Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" value="0" readonly required>

                <label>ID Donasi</label>
                <input type="number" name="id_donasi" required>
            </div>

            <button type="submit" class="btn-submit">Simpan Transaksi</button>
        </form>
    </div>
</div>

<script>
const produkList = document.getElementById('produk-list');
const btnTambah = document.getElementById('btn-tambah-produk');
const inputTotal = document.getElementById('total');
const inputQRIS = document.getElementById('QRIS');
const inputTunai = document.getElementById('tunai');
const inputKembalian = document.getElementById('kembalian');

const firstSelect = document.querySelector('.select-produk');
const optionsHTML = firstSelect.innerHTML;

function hitungSemua() {
    let total = 0;

    document.querySelectorAll('.produk-item').forEach(function(item) {
        const select = item.querySelector('.select-produk');
        const qty = parseFloat(item.querySelector('.input-qty').value || 0);
        const opt = select.options[select.selectedIndex];

        const harga = parseFloat(opt.getAttribute('data-harga') || 0);
        const diskon = parseFloat(opt.getAttribute('data-diskon') || 0);

        item.querySelector('.input-harga').value = harga;
        item.querySelector('.input-diskon').value = diskon;

        total += (harga * qty) - diskon;
    });

    inputTotal.value = total;

    // kembalian otomatis = (QRIS + Tunai) - Total
    const bayar = parseFloat(inputQRIS.value || 0) + parseFloat(inputTunai.value || 0);
    inputKembalian.value = bayar - total;
}

function bindProdukItem(item) {
    item.querySelector('.select-produk').addEventListener('change', hitungSemua);
    item.querySelector('.input-qty').addEventListener('input', hitungSemua);
}

bindProdukItem(document.querySelector('.produk-item'));
inputQRIS.addEventListener('input', hitungSemua);
inputTunai.addEventListener('input', hitungSemua);

btnTambah.addEventListener('click', function() {
    if (document.querySelectorAll('.produk-item').length >= 5) {
        alert('Maksimal 5 produk');
        return;
    }

    const div = document.createElement('div');
    div.className = 'produk-item input-group';
    div.style.marginTop = '16px';
    div.innerHTML = `
        <label>Produk</label>
        <select name="id_produk[]" class="select-produk" required>${optionsHTML}</select>

        <label>Kuantitas</label>
        <input type="number" name="kuantitas[]" class="input-qty" min="1" value="1" required>

        <label>Harga</label>
        <input type="number" name="harga[]" class="input-harga" readonly required>

        <label>Diskon</label>
        <input type="number" name="diskon[]" class="input-diskon" readonly required>
    `;
    produkList.appendChild(div);
    bindProdukItem(div);
});
</script>

<?php include ROOTPATH . '/includes/footer.php'; ?>