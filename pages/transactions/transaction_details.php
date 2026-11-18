<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');
include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$kode_transaksi = $_GET['kode_transaksi'] ?? '';

if ($kode_transaksi == '') {
    echo "<script>alert('Kode transaksi tidak ditemukan'); window.location.href='list.php';</script>";
    exit;
}

// Ambil data transaksi + nama kasir
$header = mysqli_query($connection, "
    SELECT t.*, k.nama_kasir
    FROM transaksi t
    LEFT JOIN kasir k ON t.id_kasir = k.id_kasir
    WHERE t.kode_transaksi = '$kode_transaksi'
");
$data_header = mysqli_fetch_assoc($header);

$detail = mysqli_query($connection, "
    SELECT 
        dt.*,
        p.nama_produk
    FROM detail_transaksi dt
    LEFT JOIN produk p ON dt.id_produk = p.id_produk
    WHERE dt.kode_transaksi = '$kode_transaksi'
");
?>

<div class="nota-wrapper">
    <div class="nota-card">
        <div class="nota-header">
            <h1>Indomaret</h1>
            <p>Nota Pembelanjaan</p>
            <hr>
            <div class="nota-info">
                <p><strong>Kode Transaksi:</strong> <?php echo htmlspecialchars($kode_transaksi); ?></p>
                <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($data_header['tanggal_transaksi'] ?? '-'); ?>
                </p>
                <p><strong>No. Order:</strong> <?php echo htmlspecialchars($data_header['no_order'] ?? '-'); ?></p>
                <p><strong>Kasir:</strong> <?php echo htmlspecialchars($data_header['nama_kasir'] ?? '-'); ?></p>
            </div>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $grand_total = 0;

                while ($row = mysqli_fetch_assoc($detail)) {
                    $subtotal = ($row['harga'] * $row['kuantitas']) - $row['diskon'];
                    $grand_total += $subtotal;

                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_produk'] ?? ('Produk #' . $row['id_produk'])) . "</td>";
                    echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['kuantitas'] . "</td>";
                    echo "<td>Rp " . number_format($row['diskon'], 0, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="nota-footer">
            <hr>
            <p><strong>Total Belanja:</strong> Rp
                <?php echo number_format($data_header['total'] ?? $grand_total, 0, ',', '.'); ?></p>
            <p><strong>QRIS:</strong> Rp <?php echo number_format($data_header['QRIS'] ?? 0, 0, ',', '.'); ?></p>
            <p><strong>Tunai:</strong> Rp <?php echo number_format($data_header['tunai'] ?? 0, 0, ',', '.'); ?></p>
            <p><strong>Kembalian:</strong> Rp <?php echo number_format($data_header['kembalian'] ?? 0, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="nota-actions">
            <a href="list.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>

<?php include ROOTPATH . '/includes/footer.php'; ?>