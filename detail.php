<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $search = $_GET['id'];
    $queryProduk = mysqli_query($con, "SELECT produk.*, kategori.nama AS kategori FROM produk JOIN kategori ON produk.kategori_id = kategori.id WHERE produk.id = '" . $search . "'");
} else {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumi Acuk</title>

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include "header.php"; ?>

    <!-- trending-product-section> -->
    <section class="trending-product" id="trending">
        <div class="mt-5 pt-5">
            <?php

            if ($data = mysqli_fetch_array($queryProduk)) {
            ?>

                <div class="row">
                    <div class="col-4 d-flex justify-content-end">
                        <img style="width: 100%;" src="<?php echo "upload/" . $data['foto'] ?>" alt="">
                    </div>
                    <div class="col-6">
                        <div class="product-text">
                            <h5><?php echo $data['kategori'] ?></h5>
                        </div>
                        <div class="heart-icon">
                            <i class='bx bx-heart'></i>
                        </div>
                        <div class="price">
                            <h4><?php echo $data['nama'] ?></h4>
                            <p class="text-muted">Rp. <?php echo $data['harga'] ?></p>
                            <p class="text-muted">Stok: <?php echo $data['ketersediaan_stok'] ?></p>
                            <p><?php echo $data['detail'] ?></p>
                        </div>
                    </div>
                </div>

            <?php
            }

            ?>
        </div>

    </section>

    <!-- contact-section -->
    <section class="contact">
        <div class="contact-info">
            <div class="first-info">
                <img src="assets/logo.png" alt="">

                <p>Jl. Siliwangi No.31A, Pamoyanan <br>Kec. Cianjur, 43211</p>
                <p>087778765551</p>
                <p>bumiacuk@gmail.com</p>

                <div class="social-icon">
                    <a href="https://www.instagram.com/bumi_acuk/"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-tiktok'></i></a>
                </div>
            </div>

            <div class="second-info">
                <h4>Support</h4>
                <p>Contact Us</p>
                <p>About Page</p>
                <p>Size Guide</p>
                <p>Shopping & Return</p>
                <p>Privacy</p>
            </div>

            <div class="thrid-info">
                <h4>Shop</h4>
                <p>Women</p>
                <p>Men</p>
                <p>KidS</p>
                <p>Accessories</p>
            </div>

            <div class="fourth-info">
                <h4>Company</h4>
                <p>Blog</p>
                <p>Affiliate</p>
                <p>Login</p>
            </div>

            <div class="five">
                <h4>Subscribe</h4>
                <p>Receive updates, hot deals, discounts sent stajsnfjasfsf</p>
                <p>kiren uosum dolor sit amet consectetr audsad elit eum debits</p>
                <p>kiren uosum dolor sit amet consectetr audsad elit eum debits</p>
            </div>
        </div>
    </section>

    <div class="end-text">
        <p>© 2023 Bumi Acuk</p>
    </div>

    <script src="java.js"></script>

</body>

</html>