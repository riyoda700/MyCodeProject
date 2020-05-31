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
     <title>Customer List</title>
     <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>

     <script>
         Add = () =>{
             document.getElementById('action').value = "insert";
             document.getElementById('id_customer').value = "";
             document.getElementById('nama').value = "";
             document.getElementById('alamat').value = "";
             document.getElementById('kontak').value = "";
             document.getElementById('username').value = "";
             document.getElementById('password').value = "";
         }

         Edit = (item) =>{
            document.getElementById('action').value = "update";
             document.getElementById('id_customer').value = item.id_customer;
             document.getElementById('nama').value = item.nama;
             document.getElementById('alamat').value = item.alamat;
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
             $sql = "select * from customer where id_customer like '%$search%' or nama like '%$search%' or alamat like '%$search%' or kontak like '%$search%' or username like '%$search%'";
         }else {
             $sql = "select * from customer";
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
                <form class="form-inline my-2 my-lg-0" action="customer.php" method="post">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" id="search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    <br>
      
      <div class="container">
          <div class="card">
              <div class="card-header bg-warning text-white text-center">
                  <h1>Data Pengunjung</h1>
              </div>
              <div class="card-body">
                  <form action="customer.php" method="post">
                      <input type="text" name="search" id="search" class="form-control" placeholder="Search...">
                  </form>
                  <br>
                  <table class="table" border="1">
                      <thead>
                          <tr>
                              <td>ID Customer</td>
                              <td>Nama</td>
                              <td>Alamat</td>
                              <td>Kontak</td>
                              <td>Username</td>
                              <td>Password</td>
                              <td>Option</td>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($query as $customer): ?>
                              <tr>
                                  <td><?php echo $customer["id_customer"]?></td>
                                  <td><?php echo $customer["nama"]?></td>
                                  <td><?php echo $customer["alamat"]?></td>
                                  <td><?php echo $customer["kontak"]?></td>
                                  <td><?php echo $customer["username"]?></td>
                                  <td><?php echo $customer["password"]?></td>
                                  <td>
                                      <button data-toggle="modal" data-target="#modal_customer" type="button"
                                      class="btn btn-sm btn-dark" onclick='Edit(<?php echo json_encode($customer);?>)'>
                                        Edit
                                      </button>
                                      <a href="crud_customer.php?delete=true&id_customer=<?php echo $customer["id_customer"];?>"
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
                  <button type="button" class="btn btn-dark" style="margin-left: 15px;" data-toggle="modal"
                  data-target="#modal_customer" onclick="Add()">Tambahkan Data</button>
              </div>
              <div class="card-footer text-center">
                  <p>&copy;2020 <br> Alfian Nurdi</p>
              </div>
          </div>

          <div class="modal fade" id="modal_customer">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <form action="crud_customer.php" method="post">
                          <div class="modal-header bg-warning text-white">
                              <h2>Data Pengunjung</h2>
                              <span class="close" data-dismiss="modal">&times;</span>
                          </div>
                          <div class="modal-body">
                              <input type="hidden" name="action" id="action">
                              ID Pengunjung <span style="color: red;">*</span>
                              <input type="number" name="id_customer" id="id_customer" class="form-control" required />
                              Nama <span style="color: red;">*</span>
                              <input type="text" name="nama" id="nama" class="form-control" required />
                              Alamat <span style="color: red;">*</span>
                              <input type="text" name="alamat" id="alamat" class="form-control" required />
                              Kontak <span style="color: red;">*</span>
                              <input type="number" name="kontak" id="kontak" class="form-control" required />
                              Username <span style="color: red;">*</span>
                              <input type="text" name="username" id="username" class="form-control" required />
                              Password <span style="color: red;">*</span>
                              <input type="password" name="password" id="password" class="form-control" required />
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-dark" name="save_customer">Save</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
 </body>
 </html>