<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$kode_transaksi = $_GET['kode_transaksi'] ?? '';

if ($kode_transaksi == '') {
    echo "<script>
        alert('Kode transaksi tidak ditemukan');
        window.location.href='list.php';
    </script>";
    exit;
}

$kode_transaksi = mysqli_real_escape_string($connection, $kode_transaksi);

$header = mysqli_query($connection, "
    SELECT
        transaksi.*,
        kasir.nama_kasir
    FROM transaksi
    LEFT JOIN kasir
        ON transaksi.id_kasir = kasir.id_kasir
    WHERE transaksi.kode_transaksi = '$kode_transaksi'
");

if (!$header) {
    die("Query transaksi error: " . mysqli_error($connection));
}

$data_header = mysqli_fetch_assoc($header);

if (!$data_header) {
    echo "<script>
        alert('Data transaksi tidak ditemukan');
        window.location.href='list.php';
    </script>";
    exit;
}

$nama_kasir = $data_header['nama_kasir'] ?? '-';

if (empty($nama_kasir)) {
    $nama_kasir = '-';
}

$detail = mysqli_query($connection, "
    SELECT
        dt.*,
        p.nama_produk
    FROM detail_transaksi dt
    LEFT JOIN produk p
        ON dt.id_produk = p.id_produk
    WHERE dt.kode_transaksi = '$kode_transaksi'
");

if (!$detail) {
    die("Query detail transaksi error: " . mysqli_error($connection));
}

$no = 1;
$grand_total = 0;
$total_item = 0;
$jumlah_produk = 0;

$detail_produk = [];

while ($row = mysqli_fetch_assoc($detail)) {

    $harga = (float) $row['harga'];
    $kuantitas = (int) $row['kuantitas'];
    $diskon = (float) $row['diskon'];

    $subtotal = ($harga * $kuantitas) - $diskon;

    $row['subtotal'] = $subtotal;

    $grand_total += $subtotal;
    $total_item += $kuantitas;
    $jumlah_produk++;

    $detail_produk[] = $row;
}

$total_belanja = $data_header['total'] ?? $grand_total;

$qris = $data_header['QRIS'] ?? 0;
$tunai = $data_header['tunai'] ?? 0;
$kembalian = $data_header['kembalian'] ?? 0;

function formatRupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>

<div class="nota-wrapper">
    <div class="nota-card">
        <div class="nota-header">
            <h1>Indomaret</h1>
            <p>Nota Pembelanjaan</p>

            <hr>
            <div class="nota-info">

                <p>
                    <strong>Kode Transaksi:</strong>
                    <?= htmlspecialchars($kode_transaksi); ?>
                </p>

                <p>
                    <strong>Tanggal:</strong>
                    <?= htmlspecialchars($data_header['tanggal_transaksi'] ?? '-'); ?>
                </p>

                <p>
                    <strong>No. Order:</strong>
                    <?= htmlspecialchars($data_header['no_order'] ?? '-'); ?>
                </p>

                <p>
                    <strong>Kasir:</strong>
                    <?= htmlspecialchars($nama_kasir); ?>
                </p>

            </div>

        </div>

        <table class="nota-table">
            <td>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                </tr>
            </td>

            <tbody>

                <?php if (!empty($detail_produk)): ?>

                <?php foreach ($detail_produk as $row): ?>

                <tr>

                    <td>
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                                    $row['nama_produk']
                                    ?? ('Produk #' . $row['id_produk'])
                                ); ?>
                    </td>

                    <td>
                        Rp <?= formatRupiah($row['harga']); ?>
                    </td>

                    <td>
                        <?= $row['kuantitas']; ?>
                    </td>

                    <td>
                        Rp <?= formatRupiah($row['diskon']); ?>
                    </td>

                    <td>
                        Rp <?= formatRupiah($row['subtotal']); ?>
                    </td>

                </tr>

                <?php endforeach; ?>

                <?php else: ?>

                <tr>
                    <td colspan="6" style="text-align: center;">
                        Produk belum tercatat
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="nota-footer">
            <hr>
            <p>
                <strong>Jumlah Produk:</strong>
                <?= $jumlah_produk; ?> Produk
            </p>

            <p>
                <strong>Total Item:</strong>
                <?= $total_item; ?> Item
            </p>

            <p>
                <strong>Total Belanja:</strong>
                Rp <?= formatRupiah($total_belanja); ?>
            </p>

            <p>
                <strong>QRIS:</strong>
                Rp <?= formatRupiah($qris); ?>
            </p>

            <p>
                <strong>Tunai:</strong>
                Rp <?= formatRupiah($tunai); ?>
            </p>

            <p>
                <strong>Kembalian:</strong>
                Rp <?= formatRupiah($kembalian); ?>
            </p>

        </div>

        <div class="nota-actions">

            <a href="list.php" class="btn btn-primary">
                Kembali
            </a>
        </div>
    </div>
</div>

<?php include ROOTPATH . '/includes/footer.php'; ?>