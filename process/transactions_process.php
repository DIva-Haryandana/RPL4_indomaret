<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>
        alert('Akses tidak valid');
        window.location.href='../pages/transactions/list.php';
    </script>";
    exit;
}

$kode_transaksi = trim($_POST['kode_transaksi'] ?? '');
$id_kasir       = (int) ($_POST['id_kasir'] ?? 0);
$no_order       = trim($_POST['no_order'] ?? '');
$QRIS           = (float) ($_POST['QRIS'] ?? 0);
$tunai          = (float) ($_POST['tunai'] ?? 0);
$kembalian      = (float) ($_POST['kembalian'] ?? 0);
$id_donasi      = (int) ($_POST['id_donasi'] ?? 0);
$action         = $_POST['action'] ?? '';

$id_produk  = $_POST['id_produk'] ?? [];
$kuantitas  = $_POST['kuantitas'] ?? [];

if ($action !== 'add') {
    echo "<script>
        alert('Action tidak dikenali');
        window.history.back();
    </script>";
    exit;
}

if (
    $kode_transaksi == '' ||
    $id_kasir <= 0 ||
    $no_order == '' ||
    empty($id_produk)
) {
    echo "<script>
        alert('Data transaksi belum lengkap');
        window.history.back();
    </script>";
    exit;
}

mysqli_begin_transaction($connection);

try {

    $cek = mysqli_prepare($connection, "
        SELECT kode_transaksi
        FROM transaksi
        WHERE kode_transaksi = ?
    ");

    mysqli_stmt_bind_param($cek, "s", $kode_transaksi);
    mysqli_stmt_execute($cek);

    $cek_result = mysqli_stmt_get_result($cek);

    if (mysqli_num_rows($cek_result) > 0) {
        throw new Exception("Kode transaksi sudah digunakan");
    }

    mysqli_stmt_close($cek);

    $total = 0;
    $data_detail = [];

    foreach ($id_produk as $index => $produk_id) {

        $produk_id = (int) $produk_id;
        $qty = (int) ($kuantitas[$index] ?? 0);

        if ($produk_id <= 0 || $qty <= 0) {
            throw new Exception("Produk atau kuantitas tidak valid");
        }

        $stmt_produk = mysqli_prepare($connection, "
            SELECT harga, diskon
            FROM produk
            WHERE id_produk = ?
        ");

        mysqli_stmt_bind_param(
            $stmt_produk,
            "i",
            $produk_id
        );

        mysqli_stmt_execute($stmt_produk);

        $result_produk = mysqli_stmt_get_result($stmt_produk);

        $produk = mysqli_fetch_assoc($result_produk);

        mysqli_stmt_close($stmt_produk);

        if (!$produk) {
            throw new Exception("Produk tidak ditemukan");
        }

        $harga = (float) $produk['harga'];
        $diskon = (float) $produk['diskon'];

        $subtotal = ($harga * $qty) - $diskon;

        if ($subtotal < 0) {
            throw new Exception("Diskon tidak valid");
        }

        $total += $subtotal;

        $data_detail[] = [
            'id_produk' => $produk_id,
            'harga' => $harga,
            'kuantitas' => $qty,
            'diskon' => $diskon,
            'harga_jual' => $subtotal
        ];
    }

    if (($QRIS + $tunai) < $total) {
        throw new Exception("Pembayaran kurang dari total belanja");
    }

    $kembalian = ($QRIS + $tunai) - $total;

    $stmt_transaksi = mysqli_prepare($connection, "
        INSERT INTO transaksi
        (
            kode_transaksi,
            tanggal_transaksi,
            no_order,
            id_kasir,
            total,
            QRIS,
            tunai,
            kembalian,
            id_donasi
        )
        VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt_transaksi,
        "ssiddddi",
        $kode_transaksi,
        $no_order,
        $id_kasir,
        $total,
        $QRIS,
        $tunai,
        $kembalian,
        $id_donasi
    );

    if (!mysqli_stmt_execute($stmt_transaksi)) {
        throw new Exception(
            mysqli_stmt_error($stmt_transaksi)
        );
    }

    mysqli_stmt_close($stmt_transaksi);

    $stmt_detail = mysqli_prepare($connection, "
        INSERT INTO detail_transaksi
        (
            kode_transaksi,
            id_kasir,
            id_produk,
            harga,
            kuantitas,
            diskon,
            harga_jual
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($data_detail as $item) {

        mysqli_stmt_bind_param(
            $stmt_detail,
            "siididd",
            $kode_transaksi,
            $id_kasir,
            $item['id_produk'],
            $item['harga'],
            $item['kuantitas'],
            $item['diskon'],
            $item['harga_jual']
        );

        if (!mysqli_stmt_execute($stmt_detail)) {
            throw new Exception(
                mysqli_stmt_error($stmt_detail)
            );
        }

    }

    mysqli_stmt_close($stmt_detail);

    mysqli_commit($connection);

    echo "<script>
        alert('Transaksi dan detail produk berhasil disimpan!');
        window.location.href='../pages/transactions/list.php';
    </script>";

} catch (Exception $e) {

    mysqli_rollback($connection);

    echo "<script>
        alert('Gagal menyimpan transaksi: " .
        addslashes($e->getMessage()) .
        "');
        window.history.back();
    </script>";
}
?>