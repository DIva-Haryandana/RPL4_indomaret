<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/indo_rpl/');
include ROOTPATH . '/includes/header.php';
include ROOTPATH . '/config/config.php';

$id = $_GET['id_produk'];
$query = "SELECT * FROM produk WHERE id_produk = '$id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

?>
<div class="form-wrapper">
    <div class="form-card">
        <h1>Edit Data Produk</h1>
        <p class="form-subtitle">Ubah data produk di bawah ini</p>

        <form action="/indo_rpl/process/products_process.php" method="post">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
            <div class="input-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" value="<?php echo htmlspecialchars($row['nama_produk']); ?>"
                    id="nama_produk" placeholder="Masukkan nama produk..." required>

                <label for="harga">Harga Produk</label>
                <input type="number" name="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" id="harga"
                    placeholder="Masukkan harga produk..." required>

                <label for="diskon">Diskon</label>
                <input type="number" name="diskon" value="<?php echo htmlspecialchars($row['diskon']); ?>" id="diskon"
                    placeholder="Masukkan diskon..." required>
            </div>
            <button type="submit" class="btn-submit">Edit Produk</button>
        </form>
    </div>
</div>

<?php
include ROOTPATH . '/includes/footer.php';
?>