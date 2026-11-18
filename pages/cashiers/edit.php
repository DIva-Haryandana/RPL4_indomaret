<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');
include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$id = $_GET['id_kasir'];
$query = "SELECT * FROM kasir WHERE id_kasir = '$id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

?>
<div class="form-wrapper">
    <div class="form-card">
        <h1>Edit Data Kasir</h1>
        <p class="form-subtitle">Ubah data kasir di bawah ini</p>

        <form action="/indo_rpl/process/cashiers_process.php" method="post">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id_kasir" value="<?php echo $row['id_kasir']; ?>">
            <div class="input-group">
                <label for="nama_kasir">Nama Kasir</label>
                <input type="text" name="nama_kasir" value="<?php echo htmlspecialchars($row['nama_kasir']); ?>"
                    id="nama_kasir" placeholder="Masukkan nama Kasir..." required>

                <label for="no_tlp">Nomor Telepon</label>
                <input type="tel" name="no_tlp" value="<?php echo htmlspecialchars($row['no_tlp']); ?>" id="no_tlp"
                    placeholder="Masukkan nomor telepon Kasir..." required>

                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat Kasir..."
                    required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
            </div>
            <button type="submit" class="btn-submit">Edit Kasir</button>
        </form>
    </div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>