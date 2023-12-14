<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($con, "SELECT produk.*, kategori.nama AS kategori FROM produk JOIN kategori ON produk.kategori_id = kategori.id WHERE produk.id = $id");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form id="form-add" action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="form-control">
                        <?php
                        $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

                        if ($queryKategori) {
                            while ($row = mysqli_fetch_assoc($queryKategori)) {
                                echo "<option value='{$row['id']}' " . ($data['kategori_id'] == $row['id'] ? 'selected' : '') . ">{$row['nama']}</option>";
                            }
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="kategori">Nama</label>
                    <input type="text" id="kategori" name="nama" placeholder="Input Nama" class="form-control" value="<?php echo $data['nama']; ?>" required>
                </div>
                <div>
                    <label for="kategori">Harga</label>
                    <input type="number" min="0" id="kategori" name="harga" placeholder="Input Harga" class="form-control" value="<?php echo $data['harga']; ?>" step="0.1" required>
                </div>
                <div>
                    <label for="kategori">Warna</label>
                    <input type="text" id="kategori" name="detail" placeholder="Input Warna" class="form-control" value="<?php echo $data['detail']; ?>" required>
                </div>
                <div>
                    <label for="kategori">Stok</label>
                    <input type="number" min="0" id="kategori" name="ketersediaan_stok" placeholder="Stok" class="form-control" value="<?php echo $data['ketersediaan_stok']; ?>" required>
                </div>
                <div>
                    <label for="kategori">Foto</label>
                    <input type="file" id="kategori" name="foto" class="form-control">
                    <img src="../upload/<?php echo $data['foto']; ?>" class="img-thumbnail w-50 mt-3">
                </div>
                <div class="mt-3 mb-4 pb-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
            if (isset($_POST['editBtn'])) {
                $kategori = $_POST["kategori"];
                $nama = $_POST["nama"];
                $harga = $_POST["harga"];
                $detail = $_POST["detail"];
                $ketersediaan_stok = $_POST["ketersediaan_stok"];

                // Check if a file has been uploaded
                if ($_FILES["foto"]["error"] == 0) {
                    $foto_name = $_FILES["foto"]["name"];
                    $foto_tmp = $_FILES["foto"]["tmp_name"];
                    $foto_path = "../upload/" . $foto_name;

                    move_uploaded_file($foto_tmp, $foto_path);

                    // Update data in the "produk" table with the new photo
                    $updateQuery = "UPDATE produk SET 
                kategori_id='$kategori', 
                nama='$nama', 
                harga=$harga, 
                detail='$detail', 
                ketersediaan_stok=$ketersediaan_stok, 
                foto='$foto_name' 
                WHERE id='$id'";
                } else {
                    // Update data in the "produk" table without changing the existing photo
                    $updateQuery = "UPDATE produk SET 
                kategori_id='$kategori', 
                nama='$nama', 
                harga=$harga, 
                detail='$detail', 
                ketersediaan_stok=$ketersediaan_stok
                WHERE id='$id'";
                }

                if (mysqli_query($con, $updateQuery)) {
            ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk Berhasil Diperbarui
                    </div>

                    <meta http-equiv="refresh" content="2; url= produk.php" />
                <?php
                } else {
                    echo mysqli_error($con);
                }
            }

            if (isset($_POST['deleteBtn'])) {
                $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

                if ($queryDelete) {
                ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk Berhasil Dihapus
                    </div>

                    <meta http-equiv="refresh" content="2; url= produk.php" />
            <?php
                } else {
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>