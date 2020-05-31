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
     <link href="css/all.css" rel="stylesheet">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>
     <script>
         Detail = (item) =>{
             document.getElementById('kode_buku').value = item.kode_buku;
             document.getElementById('judul').innerHTML = `Title : ${item.judul}`;
             document.getElementById('penulis').innerHTML = `Writer : ${item.penulis}`;
             document.getElementById('stock').innerHTML = `Stock : ${item.stock}`;
             document.getElementById('jumlah_beli').value = "1";
             document.getElementById('jumlah_beli').max = item.stock;

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
                    <a class="nav-link" href="toko_buku.php"><i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i>(<?php echo count($_SESSION["cart"]);?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: white"><i class="fas fa-envelope"></i></a>
                </li>
                <li class="nav-item dropdown username" style="padding-right: 50px;">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i><?php echo $_SESSION["nama"]; ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-users-cog"></i>Setting</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-heart"></i> Wishlist</a>
                        <a class="dropdown-item" href="transaksi.php"><i class="fas fa-money-bill-wave"></i>Transaction</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="proses_login_customer.php?logout=true"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="banner/banner1.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="banner/banner2.jpg" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="banner/banner3.jpg" class="d-block w-100">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($query as $buku): ?>
                <div class="card col-4">
                    <div class="card-body text-center">
                        <img src="<?php echo 'image/'. $buku['image'];?>" width="100">
                        <h5 class="text-dark"><?php echo $buku["judul"]; ?></h5>
                        <h6 class="text-secondary">Rp <?php echo $buku["harga"]; ?></h6>
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-sm btn-dark" onclick='Detail(<?php echo json_encode($buku); ?>)'
                        data-toggle="modal" data-target="#modal_detail">
                            Detail
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="modal" id="modal_detail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="text-white">Detail Buku</h4>
                        <span class="close" data-dismiss="modal">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <!-- For image -->
                                <img style="width: 100%; height: auto;" id="image">
                            </div>
                            <div class="col-6">
                                <!-- For description -->
                                <h6 id="judul"></h6>
                                <h6 id="penulis"></h6>
                                <h6 id="harga"></h6>
                                <h6 id="stock"></h6>

                                <form action="proses_cart.php" method="post">
                                    <input type="hidden" name="kode_buku" id="kode_buku">
                                    Jumlah Beli
                                    <input type="number" name="jumlah_beli" class="form-control" min="1" id="jumlah_beli">
                                    <br>
                                    <button type="submit" name="add_to_cart" class="btn btn-dark">
                                        Tambahkan ke keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>