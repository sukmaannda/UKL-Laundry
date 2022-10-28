<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Page</title>
    <link rel="stylesheet" href="css/histori.css">
</head>
<body>
    <?php
        include "header.php";
    ?>
    <div class="main_content">
        <div class="header">Tabel Histori</div>
        <div class="info">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Member</th>
                        <th>Nama User</th>
                        <th>Tanggal Transaksi</th>
                        <th>Paket Laundry - Qty - Harga</th>
                        <th>Total Harga</th>
                        <th>Status Bayar</th>
                        <th>Status Paket</th>
                        <th>Aksi</th> 
                
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include "koneksi.php";
                        $qry_histori = mysqli_query($conn, "select transaksi.*, member.nama as nama_member, user.nama as nama_user
                                                            from transaksi 
                                                            join user ON user.id = transaksi.id_user
                                                            join member ON member.id_member = transaksi.id_member
                                                            order by id_transaksi desc");
                        $no = 0;
                        while ($dt_histori = mysqli_fetch_array($qry_histori)) {
                            $total = 0;

                            $no++;
                            $paket_dibeli = "<ol>";
                            $qry_paket = mysqli_query($conn,"select * from  detail_transaksi join paket on paket.id_paket=detail_transaksi.id_paket where id_transaksi = ".$dt_histori['id_transaksi']);
                            while($dt_paket=mysqli_fetch_array($qry_paket)){ //perulangan untuk menampilkan detail transaksi dan subtotalnmya
                                $subtotal = 0;
                                $subtotal += $dt_paket['harga'] * $dt_paket['qty'];
                                $paket_dibeli .= "<li>".$dt_paket['nama_paket']."&nbsp;&nbsp;-&nbsp;&nbsp;".$dt_paket['qty']."&nbsp;&nbsp;-&nbsp;&nbsp;"."Rp. ".number_format($dt_paket['harga'], 2, ',', '.').""."</li>";
                                $total += $dt_paket['harga'] * $dt_paket['qty'];
                            }
                            $paket_dibeli.="</ol>";
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$dt_histori['nama_member']?></td>
                        <td><?=$dt_histori['nama_user']?></td>
                        <td><?=$dt_histori['tgl']?></td>
                        <td><?=$paket_dibeli?></td>
                        <td>
                            <?php
                            echo "Rp. ".number_format($total, 2, ',', '.')."";
                        ?>
                        </td>
                        <td><?=$dt_histori['dibayar']?></td>
                        <td><?=$dt_histori['status']?></td>
                        <td>
                            <?php
                            if ($dt_histori['dibayar'] == "belum_dibayar") {
                            ?>
                            <a href="ubah_status.php?id_transaksi=<?=$dt_histori['id_transaksi']?>"><button>Lunas</button></a> | 
                            <?php
                            } else {
                            ?>
                            <a href="#"><button class = "done">✔</button></a> | 
                            <?php
                            }
                            ?>
                            <?php
                            if ($dt_histori['status'] == "baru") {
                            ?>
                            <a href="ubah_status_paket.php?id_transaksi=<?=$dt_histori['id_transaksi']?>&status=diproses"><button>Diproses</button></a>
                            <?php
                            } elseif ($dt_histori['status'] == "diproses") {
                            ?>
                            <a href="ubah_status_paket.php?id_transaksi=<?=$dt_histori['id_transaksi']?>&status=selesai"><button>Selesai</button></a>
                            <?php
                            } elseif ($dt_histori['status'] == "selesai") {
                            ?>
                            <a href="ubah_status_paket.php?id_transaksi=<?=$dt_histori['id_transaksi']?>&status=diambil"><button>Diambil</button></a>
                            <?php
                            } elseif ($dt_histori['status'] == "diambil") {
                            ?>
                            <a href="#"><button class = "done">✔</button></a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>