<?php

include '../config/config.php';

$nama_kasir = $_POST["nama_kasir"];
$no_telp    = $_POST["no_telp"];
$alamat    = $_POST["alamat"];

if ($_POST ["action"] == "add") {
    $result = mysqli_query($connection, "INSERT INTO kasir VALUES (NULL, '$nama_kasir', '$no_telp', '$alamat')");

    if (!$result) {
        echo "<script>alert('Data kasir gagal ditambahkan! ".mysqli_error($connection) ."');</script>";
    } else {
        echo "<script>alert('Data kasir berhasil ditambahkan!'); window.location.href = '../pages/cashiers/list.php';</script>";
    }
} else if ($_POST ["action"] == "delete"){
    $id_kasir = $_POST["id_kasir"];
    $result = mysqli_query($connection, "DELETE FROM kasir WHERE id_kasir = '$id_kasir'");

    if (!$result) {
        echo "<script>alert('Data kasir gagal dihapus! ".mysqli_error($connection) ."');</script>";
    } else {
        echo "<script>alert('Data kasir berhasil dihapus!'); window.location.href = '../pages/cashiers/list.php';</script>";
    }
}