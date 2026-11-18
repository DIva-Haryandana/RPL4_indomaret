<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');
include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$id = $_GET['id_donasi'];
$query = "SELECT * FROM donasi WHERE id_donasi = '$id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

?>
<div class="form-wrapper">
    <div class="form-card">
        <h1>Edit Data Donasi</h1>
        <p class="form-subtitle">Ubah data donasi di bawah ini</p>

        <form action="/indo_rpl/process/donations_process.php" method="post">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id_donasi" value="<?php echo $row['id_donasi']; ?>">
            <div class="input-group">
                <label for="nama_donasi">Nama Donasi</label>
                <input type="text" name="nama_donasi" value="<?php echo htmlspecialchars($row['nama_donasi']); ?>"
                    id=" nama_donasi" placeholder="Masukkan nama donasi..." required>

                <label for="harga_donasi">Harga Donasi</label>
                <input type="number" name="harga_donasi" value="<?php echo htmlspecialchars($row['harga_donasi']); ?>"
                    id="harga_donasi" placeholder="Masukkan harga donasi..." required>

            </div>
            <button type="submit" class="btn-submit">Edit Donasi</button>
        </form>
    </div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>