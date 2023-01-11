<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pijarcamp";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("tidak konek");
} else {
    echo " Konek berhasil";
}

$nama_produk = "";
$keterangan = "";
$harga = "";
$jumlah = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op =  $_GET['op'];
} else {
    $op = "";
}


if($op == 'delete'){
    $id =  $_GET ['id'];
    $sql1= "delete from produk where id = '$id'";
    $q1= mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "berhasil di hapus";
    }else{
        $error = "gagal delete data";
    }
}


if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from produk where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama_produk= $r1['nama_produk'];
    $keterangan = $r1['keterangan'];
    $harga      = $r1['harga'];
    $jumlah     = $r1['jumlah'];

    if($nama_produk == ''){
        $error ="data tidak ada";
    }
}
if (isset($_POST['simpan'])) { // untuk create
    $nama_produk = $_POST['nama_produk'];
    $keterangan = $_POST['keterangan'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    if ($nama_produk && $keterangan && $harga && $jumlah) {
        if($op == 'edit'){ //untuk update
            $sql1= "update produk set nama_produk = '$nama_produk' ,keterangan= '$keterangan', harga='$harga', jumlah='$jumlah'where id = '$id'";
            $q1 = mysqli_query($koneksi,$sql1);

            if($q1){
                $sukses = "data berhasil di update";
            }else{
                $error = "data gagal di update";
            }
        }else { // untuk insert
            $sql1 = "insert into produk(nama_produk,keterangan,harga,jumlah) values('$nama_produk','$keterangan','$harga','$jumlah')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "berhasil";
            } else {
                $error = "gagal";
            }
        }
        
    } else {
        $error = "Masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pijar Camp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .max-auto {
            width: 800px
        }

        ;

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="max-auto">
        <!-- memasukkan data -->
        <div class="card">
            <div class="card-header">
                CREATE
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php

                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php

                }
                ?>
                <form action="" method="POST ">
                    <div class="mb-3 row">
                        <label for="nama_produk" class="col-sm-2 col-form-label">Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $nama_produk; ?>"></div>

                        <div class="mb-3 row">
                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah ?>">
                            </div>
                        </div>


                        <div class="col-12">
                            <input type="submit" name="simpan" value="simpan data" class="btn btn-primary">
                        </div>
                </form>
            </div>
        </div>
        <!-- mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                DATA PRODUK
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from produk order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 =  mysqli_fetch_array($q2)) {
                            $id =  $r2['id'];
                            $nama_produk =  $r2['nama_produk'];
                            $harga =  $r2['harga'];
                            $jumlah =  $r2['jumlah'];
                             ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row "><?php echo $nama_produk ?></td>
                                <td scope="row "><?php echo $keterangan ?></td>
                                <td scope="row "><?php echo $harga ?></td>
                                <td scope="row "><?php echo $jumlah ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo  $id ?>">  <button type="button" class="btn btn-danger">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"> <button type="button" class="btn btn-warning">Delete</button></a>
                                   
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</body>

</html>
