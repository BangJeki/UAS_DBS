<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db        = "akademik";

$koneksi   = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$NIM       = "";
$NAMA      = "";
$ALAMAT    = "";
$FAKULTAS  = "";
$SUKSES    = "";
$ERROR     = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $ID         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$ID'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $SUKSES = "BERHASIL MENGHAPUS DATA";
    } else {
        $ERROR  = "GAGAL MELAKUKAN DELETE DATA";
    }
}

if($op == 'edit'){
    $ID            = $_GET['id'];
    $sql1          = "select * from mahasiswa where id = '$ID'";
    $q1            = mysqli_query($koneksi , $sql1);
    $r1            = mysqli_fetch_array($q1);
    $NIM           = $r1['NIM'];
    $NAMA          = $r1['NAMA'];
    $ALAMAT        = $r1['ALAMAT'];
    $FAKULTAS      = $r1['FAKULTAS'];

    if($NIM == ''){
        $ERROR = "DATA TIDAK DITEMUKAN!";
    }
}

if (isset($_POST['simpan'])) {  //untuk create data
    $NIM           = $_POST['NIM'];
    $NAMA          = $_POST['NAMA'];
    $ALAMAT        = $_POST['ALAMAT'];
    $FAKULTAS      = $_POST['FAKULTAS'];

    if ($NIM && $NAMA && $ALAMAT && $FAKULTAS) {
        if($op == 'EDIT'){ //untuk update data
            $sql1       = "Update mahasiswa set NIM = '$NIM' , NAMA = '$NAMA' , ALAMAT = '$ALAMAT' , FAKULTAS = '$FAKULTAS' where id = '$ID'";
            $q1         = mysqli_query($koneksi , $sql1);
            if($q1) {
                $SUKSES = "DATA BERHASIL DIUPDATE";
            } else {
                $ERROR  = "DATA GAGAL DIUPDATE!";
            }
        } else{ // untuk insert data
            $sql1 = "Insert into mahasiswa(NIM, NAMA, ALAMAT, FAKULTAS) values ('$NIM','$NAMA', '$ALAMAT', '$FAKULTAS')";
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
    <title>Data Mahasiswa</title>
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
                        <label for="NIM" class="form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NIM" name="NIM" value="<?php echo $NIM ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NAMA" class="form-label">NAMA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NAMA" name="NAMA" value="<?php echo $NAMA ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ALAMAT" class="form-label">ALAMAT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ALAMAT" name="ALAMAT" value="<?php echo $ALAMAT ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="FAKULTAS" class="form-label">FAKULTAS</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="FAKULTAS" id="FAKULTAS">
                                <option value="">- PILIH FAKULTAS -</option>
                                <option value="FSTM" <?php if ($FAKULTAS == "FSTM") echo "selected" ?>>FSTM</option>
                                <option value="FEBIS" <?php if ($FAKULTAS == "FEBIS") echo "selected" ?>>FEBIS</option>
                                <option value="FSDH" <?php if ($FAKULTAS == "FSDH") echo "selected" ?>>FSDH</option>
                            </select>
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
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">FAKULTAS</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2  = "SELECT * from mahasiswa order by id desc";
                        $q2    = mysqli_query($koneksi, $sql2);
                        $urut  = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $ID        = $r2['ID'];
                            $NIM       = $r2['NIM'];
                            $NAMA      = $r2['NAMA'];
                            $ALAMAT    = $r2['ALAMAT'];
                            $FAKULTAS  = $r2['FAKULTAS'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $NIM ?></td>
                                <td scope="row"><?php echo $NAMA ?></td>
                                <td scope="row"><?php echo $ALAMAT ?></td>
                                <td scope="row"><?php echo $FAKULTAS ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $ID?>"><button type="button" class="btn btn-warning">EDIT</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $ID?>" onclick="return confirm('YAKIN UNTUK MENGAHPUS DATA?')"><button type="button" class="btn btn-danger">DELETE</button></a>
                                    

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