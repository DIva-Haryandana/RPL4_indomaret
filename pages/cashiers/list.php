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
        <a href="/indo_rpl/pages/cashiers/add.php" class="btn btn-primary">Tambah Kasir</a>
    </div>

    <h2>Daftar Pengguna Sistem</h2>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kasir</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../config/config.php';
                $query = "SELECT * FROM kasir";
                $result = mysqli_query($connection, $query);
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_kasir']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_tlp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id_kasir=" . $row['id_kasir'] . "' class='btn btn-warning'>Edit</a>";
                    echo " <a href='/indo_rpl/process/cashiers_process.php?action=delete&id_kasir=" . $row['id_kasir'] . "' class='btn btn-danger' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a>";
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