<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid'); window.location.href='../pages/transactions/list.php';</script>";
    exit;
}

$kode_transaksi = $_POST['kode_transaksi'] ?? '';
$no_order       = $_POST['no_order'] ?? '';
$total          = $_POST['total'] ?? 0;
$QRIS           = $_POST['QRIS'] ?? 0;
$tunai          = $_POST['tunai'] ?? 0;
$kembalian      = $_POST['kembalian'] ?? 0;
$id_donasi      = $_POST['id_donasi'] ?? 0;
$action         = $_POST['action'] ?? '';

if ($action === 'add') {
    $query = "INSERT INTO transaksi
        (kode_transaksi, tanggal_transaksi, no_order, total, QRIS, tunai, kembalian, id_donasi)
        VALUES
        ('$kode_transaksi', NOW(), '$no_order', '$total', '$QRIS', '$tunai', '$kembalian', '$id_donasi')";

    $hasil = mysqli_query($connection, $query);

    if (!$hasil) {
        echo "<script>
            alert('Gagal: " . addslashes(mysqli_error($connection)) . "');
            window.history.back();
        </script>";
    } else {
        echo "<script>
            alert('Data transaksi berhasil ditambahkan.');
            window.location.href = '../pages/transactions/list.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Action tidak dikenali');
        window.history.back();
    </script>";
}
?>