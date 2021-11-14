<?php

    $host      = "localhost";
    $user      = "root";
    $pass      = "";
    $db        = "universitas";

    $koneksi   = mysqli_connect($host, $user, $pass, $db);
    if(!$koneksi)
    {
        die("Tidak bisa terkoneksi ke database");
    }
    
    $nim        = "";
    $namamhs    = "";
    $jk         = "";
    $alamat     = "";
    $kota       = "";
    $email      = "";
    $sukses     = "";
    $error      = "";

    if (isset($_GET['op'])) 
    {
        $op = $_GET['op'];
    } 
    else 
    {
        $op = "";
    }
    if ($op == 'delete')
    {
        $id         = $_GET['id'];
        $sql1       = "DELETE FROM tbl_mhs WHERE id = '$id'";
        $q1         = mysqli_query($koneksi,$sql1);
        if($q1)
        {
            $sukses = "Data berhasil dihapus!";
        }
        else
        {
            $error  = "Data gagal dihapus!";
        }
    }
    if ($op == 'edit') 
    {
        $id         = $_GET['id'];
        $sql1       = "SELECT * FROM tbl_mhs WHERE id = '$id'";
        $q1         = mysqli_query($koneksi, $sql1);
        $r1         = mysqli_fetch_array($q1);
        $nim        = $r1['nim'];
        $namamhs    = $r1['namamhs'];
        $jk         = $r1['jk'];
        $alamat     = $r1['alamat'];
        $kota       = $r1['kota'];
        $email      = $r1['email'];


        if ($nim == '') 
        {
            $error = "Data tidak ditemukan";
        }
    }
    if (isset($_POST['simpan'])) 
    { 
        $nim        = $_POST['nim'];
        $namamhs    = $_POST['namamhs'];
        $jk         = $_POST['jk'];
        $alamat     = $_POST['alamat'];
        $kota       = $_POST['kota'];
        $email      = $_POST['email'];
        $foto       = $_FILES['foto']['name'];
        $tmp_name   = $_FILES['foto']['tmp_name'];

        $getfoto    = "assets/img/". basename($_FILES['foto']['name']);
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $getfoto))
        {
            $message = "Upload Berhasil!";
        }
        if ($nim && $namamhs && $jk && $alamat && $kota && $email && $foto) 
        {
            if ($op == 'edit')
            {
                $sql1   = "UPDATE tbl_mhs SET nim = '$nim', namamhs = '$namamhs', jk = '$jk', alamat = '$alamat', kota = '$kota', email = '$email', foto = '$foto' WHERE id = '$id'";
                $q1     = mysqli_query($koneksi, $sql1);
                if ($q1) 
                {
                    $sukses     = "Data berhasil diubah!";
                } 
                else 
                {
                    $error      = "Data Gagal diubah!";
                }
            }
            else
            {
                $sql1   = "INSERT INTO tbl_mhs(nim,namamhs,jk,alamat,kota,email,foto) VALUES ('$nim','$namamhs','$jk','$alamat','$kota','$email','$foto')";
                $q1     = mysqli_query($koneksi, $sql1);
                if ($q1) 
                {
                    $sukses     = "Data berhasil ditambahkan!";
                    ?>
                    <script type="text/javascript">
                        alert("Data berhasil ditambah");
                        location.href="?hal=data_user";
                    </script>
                <?php
                } 
                else 
                {
                    $error      = "Data gagal ditambahkan!";
                }
            }
        } 
        else 
        {
            $error = "Silahkan masukkan semua data!";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .mx-auto { width: 1200px; margin-top: 20px; }
        .table { margin-top: 20px }
        .card { margin-top: 20px }
    </style>
</head>
<body>
   <div class="mx-auto">
       <div class="card">
            <div class="card-header text-black bg-warning">
                Edit Data Mahasiswa
            </div>
            <div class="card-body">
                
                <?php
                    if($error) 
                    {
                ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>

                <?php
                            header("refresh:5;url=mahasiswa.php");//5 : detik
                    }
                ?>

                <?php
                    if ($sukses) 
                    {
                ?>
                 
                        <div class="alert alert-success" role="alert">
                            <?php echo $sukses ?>
                        </div>

                <?php
                        header("refresh:5;url=mahasiswa.php");
                    }
                ?>

                <form action= "" method= "POST" enctype="multipart/form-data">                    
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="namamhs" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namamhs" name="namamhs" value="<?php echo $namamhs ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jk" id="jk">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="L" <?php if ($jk == "L") echo "selected" ?>>L</option>
                                <option value="P" <?php if ($jk == "P") echo "selected" ?>>P</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kota" class="col-sm-2 col-form-label">Kota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kota" name="kota" value="<?php echo $kota ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="foto" name="foto" value="<?php echo $foto ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        <input type="reset" name="kosongkan" value="Kosongkan" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-black bg-info">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">ID</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Email</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                            $sql2   = "SELECT * FROM tbl_mhs ORDER BY id ASC";
                            $q2     = mysqli_query($koneksi, $sql2);
                            while ($r2 = mysqli_fetch_array($q2)) 
                            {
                                $id         = $r2['id'];
                                $nim        = $r2['nim'];
                                $namamhs    = $r2['namamhs'];
                                $jk         = $r2['jk'];
                                $alamat     = $r2['alamat'];
                                $kota       = $r2['kota'];
                                $email      = $r2['email'];
                                $foto       = $r2['foto'];
                        ?>
                                <tr class="text-center">
                                    <th scope="row"><?php echo $id ?></th>
                                    <td scope="row"><?php echo $nim ?></td>
                                    <td scope="row"><?php echo $namamhs ?></td>
                                    <td scope="row"><?php echo $jk ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row"><?php echo $kota ?></td>
                                    <td scope="row"><?php echo $email ?></td>
                                    <td scope="row"><img src="assets/img/<?php echo $foto ?>" width='100px' height='100px'></td>
                                    <td scope="row">
                                        <a href="mahasiswa.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn text-white btn-danger">Ubah</button></a>
                                        <a href="mahasiswa.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><button type="button" class="btn btn-success">Hapus</button></a>            
                                    </td>
                                </tr>
                        
                        <?php
                            }
                        ?>

                    </tbody>                   
                </table> 
            </div>
        </div>
   </div> 
</body>
</html>