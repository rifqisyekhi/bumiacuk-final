<?php 
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

?>
<header>
        <a href="index.php" class="logo"><img src="assets/logo.png" alt=""></a>
        <ul class="navmenu">
            <?php

            while ($data = mysqli_fetch_array($queryKategori)) {
            ?>
                <li><a href="index.php?search=<?php echo $data['nama'] ?>"><?php echo $data['nama'] ?></a></li>
            <?php } ?>
        </ul>

        <div class="nav-icon">
            <a href="#"><i class='bx bx-search'></i></a>
            <a href="#"><i class='bx bx-user'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>

            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>