<?php
    session_start();
    // session_start() digunakan sebagai tanda kalau kita akan menggunakan session pada halaman ini
    // session_start() harus diletakkan pada baris pertama.

    include("config.php");

    // tampung data username dan passwordnya
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($_POST["login_admin"])) {
        $sql = "select * from admin where username = '$username' and password = '$password'";
        // eksekusi query
        $query = mysqli_query($connect, $sql);
        
        $jumlah = mysqli_num_rows($query);
        // mysqli_num_rows digunakan untuk menghitung jumlah data hasil dari query

        if ($jumlah > 0) {
            // jika jumlahnya lebih dari nol, artinya terdapat data admin yang sesuai dengan username dan password
            // yang diinputkan
            // ini adalah blok kode jika login berhasil

            // mengubah hasil query ke array
            $admin = mysqli_fetch_array($query);

            // membuat session
            $_SESSION["id_admin"] = $admin["id_admin"];
            $_SESSION["nama"] = $admin["username"];

            header("location:bookstore.php");
        }else {
            // jika jumlahnya nol, artinya tidak ada admin yang sesuai dengan username dan password yang diinputkan
            // ini adalah blok kode jika login gagal
            header("location:login_admin.php");
        }
    }

    if (isset($_GET["logout"])) {
        // proses logout adalah proses untuk menghapus session yang sudah kita buat
        session_destroy();
        header("location:login_admin.php");
    }
 ?>