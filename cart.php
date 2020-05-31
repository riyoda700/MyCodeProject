<?php
    session_start();
    if (!isset($_SESSION["id_customer"])) {
        header("location:login_customer.php");
    }

    include("config.php");
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Bookstore</title>
     <link rel="icon" type="image/png" href="logo/favicon-1.png">
     <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <link href="fontawsome/css/all.css" rel="stylesheet">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>
     <script>
         Detail = (item) =>{
             document.getElementById('kode_buku').value = item.kode_buku;
             document.getElementById('judul').innerHTML = `Title : ${item.judul}`;
             document.getElementById('penulis').innerHTML = `Writer : ${item.penulis}`;
             document.getElementById('stok').innerHTML = `Stock : ${item.stok}`;
             document.getElementById('jumlah_beli').value = "1";

             document.getElementById('image').src = "image/" + item.image;
         }
     </script>
     <style>
         .carousel-inner{
             margin-bottom: 20px;
         }
         .carousel-item{
             filter: brightness(75%);
         }
         body{
             margin: 0px;
             padding: 0px;
         }
         .nav-item{
             margin-left: 25px;
         }
     </style>
 </head>
 <body>
    <?php
         if (isset($_POST["search"])) {
             $search = $_POST["search"];
             $sql = "select * from buku where judul like '%$search%' or 
                    penulis like '%$search%' or harga like '%$search%'";
         }else{
             $sql = "select * from buku";
         }
         $query = mysqli_query($connect, $sql);
      ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <img src="logo/favicon-1.png" width="65px">
                        <span>Bookstore</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="toko_buku.php" style="color: white;"><i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" style="color: white;"><i class="fas fa-shopping-cart"></i>(<?php echo count($_SESSION["cart"]); ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: white"><i class="fas fa-envelope"></i></a>
                </li>
                <li class="nav-item dropdown username" style="padding-right: 50px;">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i><?php echo $_SESSION["nama"]; ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-users-cog"></i>Setting</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-heart"></i>Wishlist</a>
                        <a class="dropdown-item" href="transaksi.php"><i class="fas fa-money-bill-wave"></i>Transaction</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="proses_login_customer.php?logout=true"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <br>

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Your Cart</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($_SESSION["cart"] as $cart): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $cart["judul"]; ?></td>
                                <td><?php echo $cart["harga"]; ?></td>
                                <td><?php echo $cart["jumlah_beli"]; ?></td>
                                <td>Rp <?php echo $cart["jumlah_beli"] * $cart["harga"]; ?></td>
                                <td>
                                    <a href="proses_cart.php?hapus=true&kode_buku=<?php echo $cart["kode_buku"]?>">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <a href="proses_cart.php?checkout=true">
                            <button type="button" class="btn btn-success">Checkout</button>
                        </a>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
 </body>
 </html>