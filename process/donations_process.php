<?php

include '../config/config.php';

$nama_donasi = $_POST["nama_donasi"];
$harga_donasi = $_POST["harga_donasi"];

if($_POST["action"] == "add"){
    $hasil = mysqli_query($connection, "INSERT INTO donasi VALUES (NULL, '$nama_donasi', '$harga_donasi')");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal menambahkan data donasi: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data donasi berhasil ditambahkan.');
        window.location.href='../pages/donations/list.php';
        </script>";
    }
}else if($_POST["action"] == "edit"){
    $id_donasi = $_POST["id_donasi"];
    $nama_donasi = $_POST["nama_donasi"];
    $harga_donasi = $_POST["harga_donasi"];
    $hasil = mysqli_query($connection, "UPDATE donasi SET nama_donasi='$nama_donasi', harga_donasi='$harga_donasi' WHERE id_donasi='$id_donasi'");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal mengupdate data donasi: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data donasi berhasil diupdate.');
        window.location.href='../pages/donations/list.php';
        </script>";
    }

}else if($_POST["action"] == "delete"){
    $id_donasi = $_POST["id_donasi"];
}else if($_GET["action"] == "delete"){
    $id_donasi = $_GET["id_donasi"];
    $hasil = mysqli_query($connection, "DELETE FROM donasi WHERE id_donasi='$id_donasi'");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal menghapus data donasi: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data donasi berhasil dihapus.');
        window.location.href='../pages/donations/list.php';
        </script>";
    }
}