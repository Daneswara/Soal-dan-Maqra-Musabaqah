<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['user_login'])) {
    header('location: login.php');
}
if (isset($_GET["surat1"]) && isset($_GET["ayat1"])) {
    $tempsurat = $_GET["surat1"];
    $tempayat = $_GET["ayat1"];

    $hal = getHalaman($tempsurat, $tempayat);
    $namasurat = getNamaSurat($tempsurat);
    $namasurat = str_replace("'", "petik", $namasurat);
    echo "<script type=\"text/javascript\">  window.open('mushaf.php?kanan=$hal&surah=$tempsurat&ayat=$tempayat&namasurat=$namasurat')</script>";
}

function getHalaman($surat, $ayat) {
    include "koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `halaman` WHERE nosurat = $surat and ayatawal <= $ayat ORDER BY no_halaman DESC LIMIT 1") or die(mysqli_error($koneksi));
    $halaman = mysqli_fetch_array($queryview);
    $kanan = $halaman['no_halaman'];
    if (mysqli_num_rows($queryview) == 0) {
        $surat = $surat - 1;
        $queryview = mysqli_query($koneksi, "SELECT * FROM `halaman` WHERE nosurat = $surat ORDER BY no_halaman DESC LIMIT 1") or die(mysqli_error($koneksi));
        $halaman = mysqli_fetch_array($queryview);
        $kanan = $halaman['no_halaman'];
    }
    return $kanan;
}

function getNamaSurat($surat) {
    include "koneksi.php";
    $queryview = mysqli_query($koneksi, "SELECT * FROM `daftarsurah` WHERE nosurat = $surat LIMIT 1") or die(mysqli_error($koneksi));
    $surah = mysqli_fetch_array($queryview);
    $namasurat = $surah['nama'];
    return $namasurat;
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SOAL DAN MAQRA' MUSABAQAH</title>
        <meta name="description" content="Flat UI Kit Free is a Twitter Bootstrap Framework design and Theme, this responsive framework includes a PSD and HTML version."/>

        <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Loading Flat UI -->
        <link href="dist/css/flat-ui.css" rel="stylesheet">
        <link href="docs/assets/css/demo.css" rel="stylesheet">

        <script src="js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/sweetalert.css">

        <link rel="shortcut icon" href="img/favicon.ico">
        <script src="js/jquery-1.10.2.js"></script>

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
                background-image: url("gambar/bg.jpg");
                background-repeat: repeat;
            }
            .navbar {
                margin-bottom: 20px;
            }
            .bigtext {
                font-size: 1400%;
                text-align: center;
            }
            .img-center {margin:0 auto;}
        </style>

        <div class="container">
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
                        <li><a href="index.php">Tilawah dan MHQ</a></li>
                        <li ><a href="tafsir.php">Tafsir</a></li>
                        <li ><a href="fahmil.php">MFQ</a></li>
                        <li ><a href="linkmushaf.php">Link Mushaf</a></li>
                        <li class="active"><a href="acak.php">Acak</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pengaturan <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="about.php">Tentang</a></li>
                                <li><a href="help.php">Bantuan</a></li>
                                <li><a href="login.php">Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div class="row">
                    <div class="col-xs-12">
                        <h3>Acak Kalimat</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" name="kalimat" id="kalimat" placeholder="Isikan kalimat yang akan diacak, pisahkan dengan Enter" class="form-control"></textarea>
                          </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <button id="resetkalimat" class="btn btn-block btn-lg btn-danger">Reset</button></div>
                            </div>
                            <div class="col-xs-6" id="tombolacakkalimat">
                                <div class="form-group">
                                    <button  id="acakkalimat" class="btn btn-block btn-lg btn-primary">Acak</button></div>
                            </div>
                            <div class="col-xs-6" id="tombolstopkalimat">
                                <div class="form-group">
                                    <button id="stopkalimat" class="btn btn-block btn-lg btn-warning">Stop</button></div>
                            </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" style="height: 150px" name="hasilkalimat" id="hasilkalimat" placeholder="Hasil acak kalimat" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <h3>Acak Angka</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <input type="number" name="angkaawal" id="angkaawal" placeholder="Isikan angka awal yang akan diacak" class="form-control">
                            <input type="number" name="angkaakhir" id="angkaakhir" placeholder="Isikan angka akhir yang akan diacak" style="margin-top: 10px" class="form-control">
                          </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <button id="resetangka" class="btn btn-block btn-lg btn-danger">Reset</button></div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group" id="tombolacakangka">
                                    <button  id="acakangka" class="btn btn-block btn-lg btn-primary">Acak</button></div>
                            </div>
                            <div class="col-xs-6" id="tombolstopangka">
                                <div class="form-group">
                                    <button id="stopangka" class="btn btn-block btn-lg btn-warning">Stop</button></div>
                            </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <textarea type="text" style="height: 150px" name="hasilangka" id="hasilangka" placeholder="Hasil acak angka" class="form-control"></textarea>
                        </div>
                    </div>
            </div> <!-- /.col-xs-3 -->
        </div> <!-- /.row -->

    </div>


    <script type="text/javascript">
    function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

        $(document).ready(function () {
          document.getElementById("tombolstopangka").style.display ='none';
            document.getElementById("tombolstopkalimat").style.display ='none';
            document.getElementById("kalimat").addEventListener('keyup', function () {
                this.style.overflow = 'hidden';
                this.style.height = 85;
                this.style.height = this.scrollHeight + 'px';
            }, false);

            var res;
            var angka = [];
            var cek = 0;
            var cek2 = 0;
            var hasilacakkalimat;
            var hasilangka;
            document.getElementById("acakkalimat").addEventListener('click', function (){
                if(cek == 0){
                  var x = document.getElementById("kalimat").value;
                  res = x.split("\n");
                  cek = 1;
                }

                if(res.length == 0){
                  document.getElementById("hasilkalimat").value = "Semua kalimat telah teracak, silahkan reset untuk mengacak ulang";
                } else {
                  document.getElementById("tombolacakkalimat").style.display ='none'
                  document.getElementById("tombolstopkalimat").style.display ='block'
                  addacakkalimat = setInterval(function () {
                    hasilacakkalimat = Math.floor(Math.random() * res.length);
                    document.getElementById("hasilkalimat").value = res[hasilacakkalimat];
                  }, 100);
                }
                console.log(res);

            }, false);

            document.getElementById("stopkalimat").addEventListener('click', function (){
            res.splice(hasilacakkalimat, 1);
              clearInterval(addacakkalimat);
                document.getElementById("tombolacakkalimat").style.display ='block'
                document.getElementById("tombolstopkalimat").style.display ='none'
            }, false);



            document.getElementById("resetkalimat").addEventListener('click', function (){
              var x = document.getElementById("kalimat").value;
              res = x.split("\n");
              document.getElementById("hasilkalimat").value = "";
              console.log(res);
            }, false);

            document.getElementById("acakangka").addEventListener('click', function (){

                var x = document.getElementById("angkaawal").value;
                var y = document.getElementById("angkaakhir").value;
                if(!isReallyNumber(x) || !isReallyNumber(y)){
                  document.getElementById("hasilangka").value = "Masukkan nilai berupa angka!";
                  cek2 = 0;
                } else if(x > y){
                  document.getElementById("hasilangka").value = "Pastikan angka awal lebih kecil dari pada angka akhir!";
                  cek2 = 0;
                } else {
                  if(cek2 == 0){
                    angka = [];
                      for (var i = x; i <= y; i++) {
                          angka.push(i);
                      }
                      cek2 = 1;
                    }
                  if(angka.length == 0){
                    document.getElementById("hasilangka").value = "Semua angka telah teracak, silahkan reset untuk mengacak ulang";
                  } else {
                    document.getElementById("tombolacakangka").style.display ='none'
                    document.getElementById("tombolstopangka").style.display ='block'

                    addacakangka = setInterval(function () {
                      hasilangka = Math.floor(Math.random() * angka.length);
                      document.getElementById("hasilangka").value = angka[hasilangka];
                    }, 100);

                  }
                  console.log(angka);
              }
            }, false);

            document.getElementById("stopangka").addEventListener('click', function (){
            angka.splice(hasilangka, 1);
              clearInterval(addacakangka);
                document.getElementById("tombolacakangka").style.display ='block'
                document.getElementById("tombolstopangka").style.display ='none'
            }, false);

            document.getElementById("resetangka").addEventListener('click', function (){
              var x = document.getElementById("angkaawal").value;
              var y = document.getElementById("angkaakhir").value;
              if(!isReallyNumber(x) || !isReallyNumber(y)){
                document.getElementById("hasilangka").value = "Masukkan nilai berupa angka!";
                cek2 = 0;
              } else if(x > y){
                document.getElementById("hasilangka").value = "Pastikan angka awal lebih kecil dari pada angka akhir!";
                cek2 = 0;
              } else {
                angka = [];
                for (var i = x; i <= y; i++) {
                    angka.push(i);
                }
                document.getElementById("hasilangka").value = "";
                console.log(angka);
              }
            }, false);
            function isReallyNumber(data) {
                data = (parseInt(data));
                return typeof data === 'number' && !isNaN(data);
            }
        });
    </script>
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>
</body>
</html>
