<?php
require "session.php";
require "../koneksi.php";

$queryProduk = mysqli_query($con, "SELECT produk.*, kategori.nama AS kategori FROM produk JOIN kategori ON produk.kategori_id = kategori.id");
$jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel/" class="no-decoration text-mutes">
                        <i class="fas fa-home"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk <button type="button" id="btn-show" class="btn btn-sm btn-success" onclick="showForm()">+</button></h3>
            <form id="form-add" class="d-none" action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="form-control">
                        <?php
                        $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

                        if ($queryKategori) {
                            while ($row = mysqli_fetch_assoc($queryKategori)) {
                                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                            }
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="kategori">Nama</label>
                    <input type="text" id="kategori" name="nama" placeholder="Input Nama" class="form-control" required>
                </div>
                <div>
                    <label for="kategori">Harga</label>
                    <input type="number" min="0" id="kategori" name="harga" placeholder="Input Harga" class="form-control" step="0.1" required>
                </div>
                <div>
                    <label for="kategori">Warna</label>
                    <input type="text" id="kategori" name="detail" placeholder="Input Warna" class="form-control" required>
                </div>
                <div>
                    <label for="kategori">Stok</label>
                    <input type="number" min="0" id="kategori" name="ketersediaan_stok" placeholder="Stok" class="form-control" required>
                </div>
                <div>
                    <label for="kategori">Foto</label>
                    <input type="file" id="kategori" name="foto" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_produk">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan_produk'])) {
                $produk = htmlspecialchars($_POST['nama']);

                $queryExist = mysqli_query($con, "SELECT nama FROM produk WHERE nama='$produk'");
                $jumlahDataProdukBaru = mysqli_num_rows($queryExist);

                if ($jumlahDataProdukBaru > 0) {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Produk Sudah Ada
                    </div>
                    <?php
                } else {
                    $kategori = $_POST["kategori"];
                    $nama = $_POST["nama"];
                    $harga = $_POST["harga"];
                    $detail = $_POST["detail"];
                    $ketersediaan_stok = $_POST["ketersediaan_stok"];

                    $foto_name = $_FILES["foto"]["name"];
                    $foto_tmp = $_FILES["foto"]["tmp_name"];
                    $foto_path = "../upload/" . $foto_name;

                    move_uploaded_file($foto_tmp, $foto_path);

                    $insertQuery = "INSERT INTO produk (kategori_id, nama, harga, detail, ketersediaan_stok, foto) 
                    VALUES ('$kategori', '$nama', $harga, '$detail', $ketersediaan_stok, '$foto_name')";

                    if (mysqli_query($con, $insertQuery)) {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Produk Berhasil Tersimpan
                        </div>
                        <meta http-equiv="refresh" content="2; url= produk.php" />
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Produk</h2>

            <div>
                <div class="row mb-4 pb-4 pt-4">
                    <?php
                    if ($jumlahProduk == 0) {
                    ?>
                        <tr>
                            <td colspan=3 class="text-center">Data produk tidak tersedia</td>
                        </tr>
                        <?php
                    } else {
                        $jumlah = 1;
                        while ($data = mysqli_fetch_array($queryProduk)) {
                        ?>
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo $data['kategori']; ?>
                                    </div>
                                    <img class="card-img rounded-0" src="../upload/<?php echo $data['foto']; ?>" alt="Foto <?php echo $data['nama']; ?>">
                                    <div class="card-body">
                                        <p class="text-muted">Rp. <?php echo $data['harga']; ?></p>
                                        <h5 class="card-title"><?php echo $data['nama']; ?> </h5>
                                        <p class="text-muted">Stok : <?php echo $data['ketersediaan_stok']; ?></p>
                                        <p class="card-text"><?php echo $data['detail']; ?></p>
                                        <a href="produk-detail.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                            $jumlah++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    <script>
        function showForm(){
            const bshow = document.getElementById('btn-show');
            if(bshow.innerText == "+"){
                bshow.classList.remove('btn-success');
                bshow.classList.add('btn-danger');
                bshow.innerHTML = "-";
                document.getElementById('form-add').classList.remove('d-none');
            }else{
                bshow.classList.remove('btn-danger');
                bshow.classList.add('btn-success');
                bshow.innerHTML = "+";
                document.getElementById('form-add').classList.add('d-none');
            }
        }
    </script>
</body>

</html>