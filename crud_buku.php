<?php
    // load config
    include("config.php");
    if (isset($_POST["save_buku"])) {
        $action = $_POST["action"];
        $kode_buku = $_POST["kode_buku"];
        $judul = $_POST["judul"];
        $penulis = $_POST["penulis"];
        $tahun = $_POST["tahun"];
        $harga = $_POST["harga"];
        $stok = $_POST["stok"];

        // menampung file image
        if (!empty($_FILES["image"]["name"])) {
            // getting image info description
            $path = pathinfo($_FILES["image"]["name"]);
            // get extension from image
            $extension = $path["extension"];

            // compile file name
            $filename = $kode_buku . "-" . rand(1,1000) . "." . $extension;
            // generate file name

        }

        // check the action
        if ($action == "insert") {
            $sql = "insert into buku values ('$kode_buku', '$judul', '$penulis', '$tahun', '$harga', '$stok', '$filename')";

            // upload file process
            move_uploaded_file($_FILES["image"]["tmp_name"],"image/".$filename);

            // excecution sql query
            mysqli_query($connect, $sql);
        }elseif ($action == "update") {
            if (!empty($_FILES["image"]["name"])) {
                // getting image info description
                $path = pathinfo($_FILES["image"]["name"]);

                // getting extension from image
                $extension = $path["extension"];

                // compile file name
                $filename = $kode_buku . "-" . rand(1,1000) . "." . $extension;

                // take data that will be edited
                $sql = "select * from buku where kode_buku='$kode_buku'";
                $query = mysqli_query($connect, $sql);
                $hasil = mysqli_fetch_array($query);

                if (file_exists("image/".$hasil["image"])) {
                    // delete previous data
                    unlink("image/" . $hasil["image"]);
                }

                // upload image
                move_uploaded_file($_FILES["image"]["tmp_name"], "image/".$filename);

                // syntax for update
                $sql = "update buku set judul='$judul', penulis='$penulis',
                        tahun='$tahun', harga='$harga', stok='$stok', image='$filename' where kode_buku='$kode_buku'";
                        // sql query excecution
                        mysqli_query($connect, $sql);
            }
        }

        header("location:bookstore.php");
    }

    if (isset($_GET["delete"])) {
        $kode_buku = $_GET["kode_buku"];

        $sql = "select * from buku where kode_buku='$kode_buku'";
        $query = mysqli_query($connect, $sql);
        $hasil = mysqli_fetch_array($query);
        $sql = "delete from buku where kode_buku='$kode_buku'";
        
        if (file_exists("image/" . $hasil["image"])) {
            unlink("image/" . $hasil["image"]);
        }
        mysqli_query($connect, $sql);

        // direct to bookstore.php page
        header("location:bookstore.php");
    }
 ?>