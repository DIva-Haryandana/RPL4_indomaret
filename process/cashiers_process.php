<?php

include '../config/config.php';

$nama_kasir = $_POST["nama_kasir"];
$no_telp    = $_POST["no_telp"];
$alamat    = $_POST["alamat"];

$result = mysqli_query($connection, "INSERT INTO kasir VALUES (NULL, '$nama_kasir', '$no_telp', '$alamat')");

if (!$result) {
    echo "<script>alert('Data kasir gagal ditambahkan! ".mysqli_error($connection) ."');</script>";
} else {
    echo "<script>alert('Data kasir berhasil ditambahkan!'); window.location.href = '../pages/cashiers/list.php';</script>";
}