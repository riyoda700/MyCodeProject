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
     <title>Data Buku</title>
     <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>
     <script>
         Add = () =>{
             document.getElementById('action').value = "insert";
             document.getElementById('kode_buku').value = "";
             document.getElementById('judul').value = "";
             document.getElementById('penulis').value = "";
             document.getElementById('tahun').value = "";
             document.getElementById('harga').value = "";
             document.getElementById('stok').value = "";
         }
         Edit = (item) =>{
            document.getElementById('action').value = "update";
             document.getElementById('kode_buku').value = item.kode_buku;
             document.getElementById('judul').value = item.judul;
             document.getElementById('penulis').value = item.penulis;
             document.getElementById('tahun').value = item.tahun;
             document.getElementById('harga').value = item.harga;
             document.getElementById('stok').value = item.stok;
         }
     </script>
 </head>
 <body>
     <?php
         if (isset($_POST["search"])) {
             $search = $_POST["search"];
             $sql = "select * from buku where kode_buku like '%$search%' or judul like '%$search%' or 
                    penulis like '%$search%' or tahun like '%$search%' or harga like '%$search%'";
         }else{
             $sql = "select * from buku";
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
                <form class="form-inline my-2 my-lg-0" action="bookstore.php" method="post">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" id="search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    <br>

     <div class="container">
         <div class="card">
             <div class="card-header bg-warning text-white text-center">
                 <h1>Data Buku</h1>
             </div>
             <div class="card-body">
                 <table class="table" border="1">
                     <thead>
                         <tr>
                             <td>ISBN</td>
                             <td>Judul</td>
                             <td>Penulis</td>
                             <td>Tahun Terbit</td>
                             <td>Harga</td>
                             <td>Persediaan</td>
                             <td>Tampilan Buku</td>
                             <td>Opsi</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach ($query as $buku): ?>
                             <tr>
                                 <td><?php echo $buku["kode_buku"]?></td>
                                 <td><?php echo $buku["judul"]?></td>
                                 <td><?php echo $buku["penulis"]?></td>
                                 <td><?php echo $buku["tahun"]?></td>
                                 <td><?php echo $buku["harga"]?></td>
                                 <td><?php echo $buku["stock"]?></td>
                                 <td>
                                    <img src="<?php echo 'image/'.$buku['image']?>" width="200px" />
                                 </td>
                                 <td>
                                     <button data-toggle="modal" data-target="#modal_buku" type="button"
                                     class="btn btn-sm btn-dark" onclick='Edit(<?php echo json_encode($buku)?>)'>
                                        Edit
                                     </button>
                                     <a href="crud_buku.php?delete=true&kode_buku=<?php echo $buku["kode_buku"];?>"
                                     onclick="return confirm('Are you sure to delete this item?')">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Hapus
                                        </button>
                                     </a>
                                 </td>
                             </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
                 <button type="button" class="btn btn-dark text-whitex" style="margin-left: 15px" data-toggle="modal"
                 data-target="#modal_buku" onclick="Add()">Tambah Data</button>
             </div>
             <div class="card-footer text-center">
                 <p>&copy;2020 <br> Alfian Nurdi</p>
             </div>
         </div>

         <div class="modal fade" id="modal_buku">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <form action="crud_buku.php" method="post" enctype="multipart/form-data">
                         <div class="modal-header bg-warning text-white">
                             <h1>Data Buku</h1>
                             <span class="close" data-dismiss="modal">&times;</span>
                         </div>
                         <div class="modal-body">
                             <input type="hidden" name="action" id="action">
                             ISBN
                             <input type="number" name="kode_buku" id="kode_buku" class="form-control" required />
                             Judul
                             <input type="text" name="judul" id="judul" class="form-control" required />
                             Penulis
                             <input type="text" name="penulis" id="penulis" class="form-control" required />
                             Tahun Terbit
                             <input type="text" name="tahun" id="tahun" class="form-control" required />
                             Harga
                             <input type="number" name="harga" id="harga" class="form-control" required />
                             Persediaan
                             <input type="number" name="stok" id="stok" class="form-control" required />
                             Tampilan Buku
                             <input type="file" name="image" id="image" class="form-control" required />
                         </div>
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-dark" name="save_buku">
                                 Save
                             </button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </body>
 </html>