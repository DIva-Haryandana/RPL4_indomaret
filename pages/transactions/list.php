<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/indo_rpl/assets/css/style.css/">
</head>

<body>
    <?php
    define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

    include ROOTPATH . '/includes/header.php';
    ?>


    <div class="table-action-header">
        <a href="/indo_rpl/pages/transactions/add.php" class="btn btn-primary">Tambah Transaksi</a>
    </div>

    <h2>Daftar Transaksi</h2>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>No. Order</th>
                    <th>Total</th>
                    <th>QRIS</th>
                    <th>Tunai</th>
                    <th>Kembalian</th>
                    <th>ID Donasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../config/config.php';
                $query = "SELECT * FROM transaksi";
                $result = mysqli_query($connection, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['kode_transaksi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_transaksi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_order']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['QRIS']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tunai']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kembalian']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_donasi']) . "</td>";
                    echo "<td>";
                    echo "<a href='/indo_rpl/pages/transactions/transaction_details.php?kode_transaksi=" . $row['kode_transaksi'] . "' class='btn btn-warning'>Detail</a>";
                    echo "</td>";
                echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
        include ROOTPATH . '/includes/footer.php';
    ?>

</body>

</html>