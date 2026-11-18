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
        <a href="/indo_rpl/pages/products/add.php" class="btn btn-primary">Tambah Produk</a>
    </div>

    <h2>Daftar Produk</h2>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Diskon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../config/config.php';
                $query = "SELECT * FROM produk";
                $result = mysqli_query($connection, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['harga']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['diskon']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id_produk=" . $row['id_produk'] . "' class='btn btn-warning'>Edit</a>";
                    echo " <a href='/indo_rpl/process/products_process.php?action=delete&id_produk=" . $row['id_produk'] . "' class='btn btn-danger' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a>";
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