<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$acara = $pengaturan['acara'];
$acara = str_replace("<petik>", "'", $acara);
$logo = $pengaturan['logo'];
if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query_mysql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($query_mysql);
    if ($cek == 0) {
        $querytambah = mysqli_query($koneksi, "INSERT INTO user VALUES(NULL, '$username', '$password', '$nama')") or die(mysqli_error($koneksi));
        if ($querytambah) {
            header('location: juri.php?note=1');
        } else {
            header('location: juri.php?note=12');
        }
    } else {
        header('location: juri.php?note=12');
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $queryhapus = mysqli_query($koneksi, "DELETE FROM user WHERE id = $id");

    if ($queryhapus) {
        header('location: juri.php?note=3');
    } else {
        header('location: juri.php?note=31');
    }
}
if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $nama = $_POST['namabaru'];
    $username = $_POST['usernamebaru'];
    $password = md5($_POST['passwordbaru']);

    $query_mysql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' OR id =$id") or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($query_mysql);
    if ($cek <= 1) {
        $queryupdate = mysqli_query($koneksi, "UPDATE user SET nama = '$nama', username = '$username', password ='$password' WHERE id = $id");

        if ($queryupdate) {
            header('location: juri.php?note=2');
        } else {
            header('location: juri.php?note=21');
        }
    } else {
        header('location: juri.php?note=21');
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="../js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/sweetalert.css">
        <!-- Loading Flat UI -->
        <link href="../dist/css/flat-ui.css" rel="stylesheet">
        <link href="../docs/assets/css/demo.css" rel="stylesheet">

        <link rel="shortcut icon" href="../img/favicon.ico">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="dist/js/vendor/html5shiv.js"></script>
          <script src="dist/js/vendor/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <?php
        if (isset($_GET['note'])) {
            $notifikasi = $_GET['note'];
            if ($notifikasi == 1) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: '1 Data Juri telah ditambahkan', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 12) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat ditambahkan, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 2) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Juri telah diedit', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 21) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat diedit, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            } else if ($notifikasi == 3) {
                echo "<script type='text/javascript'>swal({title: 'Berhasil!', text: 'Data Juri telah dihapus', confirmButtonColor: '#1abc9c', type: 'success'})</script>";
            } else if ($notifikasi == 31) {
                echo "<script type='text/javascript'>swal({title: 'Gagal!', text: 'Data Juri tidak dapat dihapus, silahkan coba lagi!', confirmButtonColor: '#1abc9c', type: 'error'})</script>";
            }
        }
        ?>
        <script type='text/javascript'>
            function konfirmasi(id) {
                swal({title: 'Apakah anda yakin ingin mengapus?',
                    text: 'anda tidak akan dapat mengembalikan data yang telah dihapus!',
                    confirmButtonColor: '#DD6B55',
                    closeOnConfirm: false,
                    confirmButtonText: 'Iya hapus!', cancelButtonText: 'Batal',
                    showCancelButton: true,
                    type: 'warning'},
                function() {
                    window.location = "juri.php?delete="+id;
                });
            }
        </script>
        <style>
            body {
                padding-bottom: 20px;
                padding-top: 20px;
                background-image: url("../gambar/bg.jpg");
                background-repeat: repeat;
            }
            .navbar {
                margin-bottom: 20px;
            }

            /* Jendela Pop Up */
            #popup {
                width: 100%;
                height: 100%;
                position: fixed;
                background: rgba(0,0,0,.7);
                top: 0;
                left: 0;
                z-index: 9999;
                visibility: hidden;
            }
            /* Button Close */
            .close-button {
                width: 35px;
                height: 35px;
                background: #000;
                border-radius: 50%;
                border: 3px solid #fff;
                display: block;
                text-align: center;
                color: #fff;
                text-decoration: none;
                position: absolute;
                top: -10px;
                right: -10px;
            }
            .window {
                width: 500px;
                height: 400px;
                background: #fff;
                border-radius: 10px;
                position: relative;
                padding: 20px;
                text-align: center;
                margin: 6% auto;
            }

            /* Memunculkan Jendela Pop Up*/
            #popup:target {
                visibility: visible;
            }
        </style>

        <div class="container">
            <div style="text-align: center; padding: 20px"><b><?php echo $acara;?></b><img style="margin-top: -10px" height="50px" src="../gambar/<?php echo $logo; ?>"></div>
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" style="padding-top: 15px; line-height: 1.15; text-align: center" href="#"><font size=4> SOAL DAN MAQRA'</font><br> MUSABAQAH</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Bank Soal</a></li>
                        <li><a href="fahmil.php">Bank Soal MFQ</a></li>
                        <li class="active"><a href="juri.php">Daftar Petugas</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li><a href="pengaturan.php">Pengaturan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <form action="juri.php" method="POST">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input type="text" name="nama" placeholder="Nama" class="form-control" required/>
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Username" class="form-control" required/>
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" class="form-control" required/>
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <button class="btn btn-block btn-lg btn-primary">Tambah Juri</button>
                    </div> <!-- /.col-xs-3 -->

                </div></form>
            <div class="table-responsive">
                <table class="table table-hover" bgcolor='#FF0000'>

                    <?php
                    $query_mysql = mysqli_query($koneksi, "SELECT * FROM user") or die(mysqli_error($koneksi));
                    $nomor = 1;
                    if (mysqli_num_rows($query_mysql) == 0) {
                        echo "<tr><td>Tidak ada juri yang terdaftar saat ini</td></tr>";
                    } else {
                        echo "<thead bgcolor='#FFFFFF'><tr>
                            <th width='100px'>No</th>
                            <th width='400px'>Nama</th>
                            <th width='400px'>Username</th>
                            <th width='100px'>Edit</th>
                            <th width='100px'>Delete</th>
                        </tr></thead><tbody>";
                        while ($data = mysqli_fetch_array($query_mysql)) {
                            echo "<tr bgcolor='#FFFFFF'><td>$nomor</td>";
                            echo "<td>" . $data['nama'] . "</td>";
                            echo "<td>" . $data['username'] . "</td>";
                            echo "<td><a href='juri.php?edit=" . $data['id'] . "#popup' class='btn btn-warning btn-xs btn-block'>Edit</a>" . "</td>";
                            echo "<td><button onclick='konfirmasi(" . $data['id'] . ");' class='btn btn-danger btn-xs btn-block'>Delete</button>" . "</td></tr>";
                            $nomor++;
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>
            <div id="popup">
                <div class="window">
                    <?php
                    $id = $_GET['edit'];

                    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id = $id");
                    $res = mysqli_fetch_array($query);
                    ?>
                    <a href="#" class="close-button" title="Close">X</a>
                    <h2>Edit</h2>
                    <form action="juri.php?update=<?php echo $id; ?>" method="POST">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="namabaru" placeholder="Nama" value="<?php echo $res['nama'] ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="usernamebaru" placeholder="Username" value="<?php echo $res['username'] ?>" class="form-control" required/>
                                </div>


                                <div class="form-group">
                                    <input type="password" name="passwordbaru" placeholder="Password Baru" class="form-control" required/>
                                </div>

                                <button class="btn btn-block btn-lg btn-primary">Edit Juri</button>
                            </div>

                        </div></form>
                </div>
            </div>

            <script src="../dist/js/vendor/jquery.min.js"></script>
            <script src="../dist/js/vendor/video.js"></script>
            <script src="../dist/js/flat-ui.min.js"></script>
            <script src="../docs/assets/js/application.js"></script>

    </body>
