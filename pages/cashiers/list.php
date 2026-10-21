<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/indomaret_rpl4/assets/css/style.css">
</head>

<body>
    <?php
    define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');

    include ROOTPATH . '/includes/header.php';
    ?>

    <h2>Daftar Pengguna Sistem</h2>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kasir</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
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
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>