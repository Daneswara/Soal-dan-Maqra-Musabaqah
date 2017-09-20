<?php
include "../koneksi.php";
session_start();
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
}
if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    $kafilah = $_POST['kafilah'];
    $kategori = $_POST['kategori'];
    $querytambah = mysqli_query($koneksi, "INSERT INTO peserta VALUES(NULL, '$nama', '$kafilah', '$kategori')") or die(mysqli_error($koneksi));
    if ($querytambah) {
        header('location: peserta.php');
    } else {
        echo "Gagal dalam menambahkan Peserta";
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $queryhapus = mysqli_query($koneksi, "DELETE FROM peserta WHERE id = $id");

    if ($queryhapus) {
        header('location: peserta.php');
    } else {
        echo "Gagal dalam menghapus Peserta";
    }
}
if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $nama = $_POST['namabaru'];
    $kafilah = $_POST['kafilahbaru'];
    $kategori = $_POST['kategoribaru'];
    
    $queryupdate = mysqli_query($koneksi, "UPDATE peserta SET nama = '$nama', kafilah = '$kafilah', kategori ='$kategori' WHERE id = $id");

    if ($queryupdate) {
        header('location: peserta.php');
    } else {
        echo "Gagal dalam mengedit Peserta";
    }
}
?><html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Flat UI - Free Bootstrap Framework and Theme</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
        <style>
            body {
                padding-bottom: 20px;
                padding-top: 20px;
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
            <nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-8">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" href="#">Hifzhil Qur'an</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="peserta.php">Peserta</a></li>
                        <li><a href="juri.php">Juri</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <form action="peserta.php" method="POST">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input type="text" name="nama" placeholder="Nama" class="form-control" />
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <div class="form-group">
                            <input type="text" name="kafilah" placeholder="Kafilah" class="form-control" />
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <div class="form-group">
                            <select name="kategori" class="form-control select select-primary" data-toggle="select" required>
                                <option value="">Pilih Kategori</option>
                                <option value="5 Juz">5 Juz</option>
                                <option value="10 Juz">10 Juz</option>
                                <option value="20 Juz">20 Juz</option>
                            </select>
                        </div>
                    </div> <!-- /.col-xs-3 -->
                    <div class="col-xs-3">
                        <button class="btn btn-block btn-lg btn-primary">Tambah Peserta</button>
                    </div> <!-- /.col-xs-3 -->

                </div></form>
            <div class="table-responsive">
                <table class="table table-striped">
                    <?php
                    $query_mysql = mysqli_query($koneksi, "SELECT * FROM peserta") or die(mysqli_error($koneksi));
                    $nomor = 1;
                    if (mysqli_num_rows($query_mysql) == 0) {
                        echo "<tr><td>Tidak ada peserta yang terdaftar saat ini</td></tr>";
                    } else {
                        echo "<thead><tr>
                            <th width='50px'>No</th>
                            <th width='400px'>Nama</th>
                            <th width='400px'>Kafilah</th>
                            <th width='150px'>Kategori</th>
                            <th width='100px'>Edit</th>
                            <th width='100px'>Delete</th>
                        </tr></thead><tbody>";
                        while ($data = mysqli_fetch_array($query_mysql)) {
                            echo "<tr><td>$nomor</td>";
                            echo "<td>" . $data['nama'] . "</td>";
                            echo "<td>" . $data['kafilah'] . "</td>";
                            echo "<td>" . $data['kategori'] . "</td>";
                            echo "<td><a href='peserta.php?edit=" . $data['id'] . "#popup' class='btn btn-warning btn-xs btn-block'>Edit</button>" . "</td>";
                            echo "<td><a href='peserta.php?delete=" . $data['id'] . "' class='btn btn-danger btn-xs btn-block'>Delete</button>" . "</td></tr>";
                            $nomor++;
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="popup">
                <div class="window">
                    <?php
                    $id = $_GET['edit'];

                    $query = mysqli_query($koneksi, "SELECT * FROM peserta WHERE id = $id");
                    $res = mysqli_fetch_array($query);
                    ?>
                    <a href="#" class="close-button" title="Close">X</a>
                    <h2>Edit</h2>
                    <form action="peserta.php?update=<?php echo $id; ?>" method="POST">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="namabaru" placeholder="Nama" value="<?php echo $res['nama'] ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="kafilahbaru" value="<?php echo $res['kafilah'] ?>" placeholder="Kafilah" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <select name="kategoribaru" class="form-control select select-primary" data-toggle="select" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="5 Juz" <?php if($res['kategori']=="5 Juz") echo 'selected';?> >5 Juz</option>
                                        <option value="10 Juz" <?php if($res['kategori']=="10 Juz") echo 'selected';?>>10 Juz</option>
                                        <option value="20 Juz" <?php if($res['kategori']=="20 Juz") echo 'selected';?>>20 Juz</option>
                                    </select>
                                </div>

                                <button class="btn btn-block btn-lg btn-primary">Edit Peserta</button>
                            </div>

                        </div></form>
                </div>
            </div>
            <script src="../dist/js/vendor/jquery.min.js"></script>
            <script src="../dist/js/vendor/video.js"></script>
            <script src="../dist/js/flat-ui.min.js"></script>
            <script src="../docs/assets/js/application.js"></script>

    </body>