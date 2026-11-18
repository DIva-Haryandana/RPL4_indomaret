<?php

include '../config/config.php';

$nama_kasir = $_POST["nama_kasir"];
$no_tlp    = $_POST["no_tlp"];
$alamat     = $_POST["alamat"];

if($_POST["action"] == "add"){
    $hasil = mysqli_query($connection, "INSERT INTO kasir VALUES (NULL, '$nama_kasir', '$no_tlp', '$alamat')");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal menambahkan data kasir: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data kasir berhasil ditambahkan.');
        window.location.href='../pages/cashiers/list.php';
        </script>";
    }
}else if($_POST["action"] == "edit"){
    $id_kasir = $_POST["id_kasir"];
    $hasil = mysqli_query($connection, "UPDATE kasir SET nama_kasir='$nama_kasir', no_tlp='$no_tlp', alamat='$alamat' WHERE id_kasir='$id_kasir'");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal mengupdate data kasir: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data kasir berhasil diupdate.');
        window.location.href='../pages/cashiers/list.php';
        </script>";
    }

}else if($_POST["action"] == "delete"){
    $id_kasir = $_POST["id_kasir"];
}else if($_GET["action"] == "delete"){
    $id_kasir = $_GET["id_kasir"];
    $hasil = mysqli_query($connection, "DELETE FROM kasir WHERE id_kasir='$id_kasir'");

    if(!$hasil){
        echo "
        <script>
        alert('Gagal menghapus data kasir: " . mysqli_error($connection) . "');
        </script>";
    } else {
        echo "<script>
        alert('Data kasir berhasil dihapus.');
        window.location.href='../pages/cashiers/list.php';
        </script>";
    }
}