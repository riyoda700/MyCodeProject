<?php
    session_start();
    if (!isset($_SESSION["id_admin"])) {
        header("location:login_admin.php");
    }
    include("config.php");
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>GNG Admin</title>
     <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>

     <script>
        Add = () =>{
            document.getElementById('action').value = "insert";
            document.getElementById('id_admin').value = "";
            document.getElementById('nama').value = "";
            document.getElementById('kontak').value = "";
            document.getElementById('username').value = "";
            document.getElementById('password').value = "";
        }

        Edit = (item) =>{
            document.getElementById('action').value = "update";
            document.getElementById('id_admin').value = item.id_admin;
            document.getElementById('nama').value = item.nama;
            document.getElementById('kontak').value = item.kontak;
            document.getElementById('username').value = item.username;
            document.getElementById('password').value = item.password;
        }
     </script>
 </head>
 <body>    
     <?php
         if (isset($_POST["search"])) {
             $search = $_POST["search"];
             $sql = "select * from admin where id_admin like '%$search%' or nama like '%$search%' or kontak like '%$search%' or username like '%$search%'";
         }else{
             $sql = "select * from admin";
         }

         $query = mysqli_query($connect, $sql);
      ?>
        <nav class="navbar navbar-expand-lg navbar-warning bg-warning">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php" style="color: white;">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer.php" style="color: white;">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookstore.php" style="color: white;">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a href="histori_transaksi.php" class="nav-link" style="color: white;">Data Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="proses_login_admin.php?logout=true" style="color: white">Logout</a>
                        <!-- <?php echo $_SESSION["nama"]; ?> -->
                    </li>   
                </ul>
                <form class="form-inline my-2 my-lg-0" action="admin.php" method="post">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" id="search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    <br>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header bg-dark text-white">
                <h1>Histori Transaksi</h1>
            </div>
            <div class="card-body">
                <?php
                    $sql = "select * from transaksi t inner join customer c 
                    on t.id_customer = c.id_customer
                    where t.id_customer = '".$_SESSION["id_customer"]."' 
                    order by t.tgl desc";

                    $query = mysqli_query($connect, $sql);
                 ?>

                 <ul class="list-group">
                     <?php foreach ($query as $transaksi): ?>
                        <li class="list-group-item mb-4">
                         <h6>ID Transaksi: <?php echo $transaksi["id_transaksi"];?></h6>
                         <h6>Nama: <?php echo $transaksi["nama"];?></h6>
                         <h6>Tgl Transaksi: <?php echo $transaksi["tgl"];?></h6>
                         <h6>List Barang: </h6>

                         <?php
                             $sql2 = "select * from detail_transaksi d inner join buku b 
                             on d.kode_buku = b.kode_buku
                             where d.id_transaksi = '".$transaksi["id_transaksi"]."'";
                             $query2 = mysqli_query($connect, $sql2);
                          ?>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; foreach ($query2 as $detail): ?>
                                    <tr>
                                        <td><?php echo $detail["judul"]; ?></td>
                                        <td><?php echo $detail["jumlah"]; ?></td>
                                        <td>Rp <?php echo number_format($detail["harga_beli"]); ?></td>
                                        <td>Rp <?php echo number_format($detail["harga_beli"] * $detail["jumlah"]); ?></td>
                                    </tr>
                                <?php
                                 $total += ($detail["harga_beli"] * $detail["jumlah"]);
                                endforeach; ?>
                            </tbody>
                        </table>
                        <h6 class="text-danger">Rp <?php echo number_format($total);?></h6>
                        </li>
                     <?php endforeach; ?>
                 </ul>
            </div>
        </div>
    </div>
 </body>
 </html>