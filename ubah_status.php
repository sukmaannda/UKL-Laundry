<?php
    include "koneksi.php";
    $update_status = mysqli_query($conn, "update transaksi set dibayar = 'dibayar', tgl_bayar = '".date('Y-m-d')."' where id_transaksi = '".$_GET['id_transaksi']."'");
    if ($update_status) {
        echo "<script>alert('Sukses mengupdate status bayar');location.href='histori.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate status bayar');location.href='histori.php';</script>";
    }
?>