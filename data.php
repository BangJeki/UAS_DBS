<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db        = "test";

$koneksi   = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$ORDERAN_KE         = "";
$NAMA_PELANGGAN    = "";
$NAMA_BARANG        = "";
$QTY                = "";
$TOTAL              = "";
$SUKSES             = "";
$ERROR              = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $ID         = $_GET['id'];
    $sql1       = "delete from abcdef where id = '$ID'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $SUKSES = "BERHASIL MENGHAPUS DATA";
    } else {
        $ERROR  = "GAGAL MELAKUKAN DELETE DATA";
    }
}

if($op == 'edit'){
    $ID                 = $_GET['id'];
    $sql1               = "select * from abcdef where id = '$ID'";
    $q1                 = mysqli_query($koneksi , $sql1);
    $r1                 = mysqli_fetch_array($q1);
    $ORDERAN_KE         = $r1['ORDERAN_KE'];
    $NAMA_PELANGGAN     = $r1['NAMA_PELANGGAN'];
    $NAMA_BARANG        = $r1['NAMA_BARANG'];
    $QTY                = $r1['QTY'];
    $TOTAL              = $r1['TOTAL'];

    if($ORDERAN_KE == ''){
        $ERROR = "DATA TIDAK DITEMUKAN!";
    }
}

if (isset($_POST['simpan'])) {  //untuk create data
    $ORDERAN_KE         = $_POST['ORDERAN_KE'];
    $NAMA_PELANGGAN     = $_POST['NAMA_PELANGGAN'];
    $NAMA_BARANG        = $_POST['NAMA_BARANG'];
    $QTY                = $_POST['QTY'];
    $TOTAL              = $_POST['TOTAL'];

    if ($ORDERAN_KE && $NAMA_PELANGGAN && $NAMA_BARANG && $QTY) {
        if($op == 'EDIT'){ //untuk update data
            $sql1       = "Update abcdef set ORDERAN_KE = '$ORDERAN_KE' , NAMA_PELANGGAN = '$NAMA_PELANGGAN' , NAMA_BARANG = '$NAMA_BARANG' , QTY = '$QTY' , TOTAL = '$TOTAL' where id = '$ID'";
            $q1         = mysqli_query($koneksi , $sql1);
            if($q1) {
                $SUKSES = "DATA BERHASIL DIUPDATE";
            } else {
                $ERROR  = "DATA GAGAL DIUPDATE!";
            }
        } else{ // untuk insert data
            $sql1 = "Insert into abcdef(ORDERAN_KE,NAMA_PELANGGAN,NAMA_BARANG,QTY,TOTAL) values ('$ORDERAN_KE', '$NAMA_PELANGGAN', '$NAMA_BARANG', '$QTY', '$TOTAL')";
            $q1   = mysqli_query($koneksi , $sql1);
            if ($q1) {
                $SUKSES      = "BERHASIL MEMASUKKAN DATA BARU";
            } else {
                $ERROR       = "GAGAL MEMASUKKAN DATA";
            }  
        }
    } else {
        $ERROR = "SILAKAN MASUKKAN SEMUA DATA!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data abcdef</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 480px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="max-auto">
        <!-- Untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($ERROR) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $ERROR ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($SUKSES) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $SUKSES ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="ORDERAN_KE" class="form-label">ORDERAN_KE</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ORDERAN_KE" name="ORDERAN_KE" value="<?php echo $ORDERAN_KE ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NAMA_PELANGGAN" class="form-label">NAMA_PELANGGAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NAMA_PELANGGAN" name="NAMA_PELANGGAN" value="<?php echo $NAMA_PELANGGAN ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NAMA_BARANG" class="form-label">NAMA_BARANG</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NAMA_BARANG" name="NAMA_BARANG" value="<?php echo $NAMA_BARANG ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="QTY" class="form-label">QTY</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="QTY" name="QTY" value="<?php echo $QTY ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="TOTAL" class="form-label">TOTAL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="TOTAL" name="TOTAL" value="<?php echo $TOTAL ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data abcdef
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ORDERAN_KE</th>
                            <th scope="col">NAMA_PELANGGAN</th>
                            <th scope="col">NAMA_BARANG</th>
                            <th scope="col">QTY</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2  = "SELECT * from abcdef order by id desc";
                        $q2    = mysqli_query($koneksi, $sql2);
                        $urut  = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $ID               = $r2['ID'];
                            $ORDERAN_KE       = $r2['ORDERAN_KE'];
                            $NAMA_PELANGGAN   = $r2['NAMA_PELANGGAN'];
                            $NAMA_BARANG      = $r2['NAMA_BARANG'];
                            $QTY              = $r2['QTY'];
                            $TOTAL            = $r2['TOTAL'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $ORDERAN_KE ?></td>
                                <td scope="row"><?php echo $NAMA_PELANGGAN ?></td>
                                <td scope="row"><?php echo $NAMA_BARANG ?></td>
                                <td scope="row"><?php echo $QTY ?></td>
                                <td scope="row"><?php echo $TOTAL ?></td>
                                <td scope="row">
                                    <a href="data.php?op=edit&id=<?php echo $ID?>"><button type="button" class="btn btn-warning">EDIT</button></a>
                                    <a href="data.php?op=delete&id=<?php echo $ID?>" onclick="return confirm('YAKIN UNTUK MENGHAPUS DATA?')"><button type="button" class="btn btn-danger">DELETE</button></a>
                                    

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