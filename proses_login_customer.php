<?php
    session_start();

    include("config.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($_POST["login_customer"])) {
        $sql = "select * from customer where username='$username' and password='$password'";
        // query execution
        $query = mysqli_query($connect, $sql);

        // menghitung jumlah data hasil dari query
        $jumlah = mysqli_num_rows($query);

        if ($jumlah > 0) {
            // jika jumlah > 0, artinya terdapat data customer yang sesuai dengan username dan password yang diinputkan

            // mengubah hasil query menjadi array
            $customer = mysqli_fetch_array($query);

            // membuat session
            $_SESSION["id_customer"] = $customer["id_customer"];
            $_SESSION["nama"] = $customer["username"];
            $_SESSION["cart"] = array();

            header("location:toko_buku.php");
        }else{
            // jika jumlah = 0, artinya tidak ada data customer yang sesuai dengan username dan password yang diinputkan
            header("location:login_customer.php");
        }
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        header("location:login_customer.php");
    }
 ?>