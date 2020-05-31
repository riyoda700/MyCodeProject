<?php
    session_start();
    include("config.php");

    if(isset($_POST["add_to_cart"])){
        // tampung kode_buku dan jumlah belinya
        $kode_buku = $_POST["kode_buku"];
        $jumlah_beli = $_POST["jumlah_beli"];

        // ambil data buku dari database sesuai dengan kode_buku yg dipilih
        $sql = "select * from buku where kode_buku = '$kode_buku'";
        $query = mysqli_query($connect, $sql); // eksekusi query
        $buku = mysqli_fetch_array($query); // menampung data dari database ke array

        $item = [
            "kode_buku" => $buku["kode_buku"],
            "judul" => $buku["judul"],
            "image" => $buku["image"],
            "harga" => $buku["harga"],
            "jumlah_beli" => $jumlah_beli
        ];

        // memasukkan item ke keranjang (cart)
        array_push($_SESSION["cart"], $item);

        header("location:toko_buku.php");
    }

    // menghapus item pada cart
    if (isset($_GET["hapus"])) {
        // tampung data kode_buku yg dihapus
        $kode_buku = $_GET["kode_buku"];

        // cari index cart sesuai dengan kode_buku yg dihapus
        $index = array_search(
            $kode_buku, array_column(
                $_SESSION["cart"], "kode_buku"
            )
        );

        // hapus item pada array
        array_splice($_SESSION["cart"], $index, 1);

        header("location:cart.php");
    }

        // checkout
        if (isset($_GET["checkout"])) {
            // memasukkan data pada cart ke database(tabel transaksi dan detail transaksi)
            // transaksi -> id_transaksi, tgl, id_customer
            // detail -> id_transaksi, kode_buku, jumlah, harga_beli

            $id_transaksi = "ID".rand(1,1000);
            $tgl = date("Y-m-d-H:i:s"); // current time
            // Y = Year, m = month, d = day, H = Hours, i = minute, s = second
            $id_customer = $_SESSION["id_customer"];

            // create insert into transaksi table query
            $sql = "insert into transaksi values ('$id_transaksi', '$tgl', '$id_customer')";
            mysqli_query($connect, $sql); // query execution


            foreach ($_SESSION["cart"] as $cart){
                $kode_buku = $cart["kode_buku"];
                $jumlah = $cart["jumlah_beli"];
                $harga_beli = $cart["harga"];

                // create query insert into detail table
                $sql = "insert into detail_transaksi values ('$id_transaksi', '$kode_buku', '$jumlah', '$harga_beli')";
                mysqli_query($connect, $sql);

                $sql2 = "update buku set stok = stok - $jumlah where kode_buku = '$kode_buku'";
                mysqli_query($connect, $sql2);
            }
            // kosongkan cart nya
            $_SESSION["cart"] = array();
            header("location:transaksi.php");
        }
 ?>