<?php
include "koneksi.php";
//session_start();
//if (!isset($_SESSION['user_login'])) {
//    header('location:login.php');
//    exit();
//}
if (!isset($_GET["kanan"])) {
    $awal = 0;
} else {
    $awal = 1;
}
if (isset($_GET["kanan"])) {
    $kanan = $_GET["kanan"];
    if (isset($_GET["surah"]) && isset($_GET["ayat"])) {
        $surah = $_GET["surah"];
        $ayat = $_GET["ayat"];
        $namasuratlink = $_GET["namasurat"];
        $awal = 0;
    } else {
        $awal = 1;
        $surah = 1;
        $ayat = 1;
    }
} else {
    $awal = 0;
    $kanan = 1;
    $surah = 1;
    $ayat = 1;
}
if (isset($_GET["surahakhir"])) {
    $surahakhir = $_GET["surahakhir"];
    $ayatakhir = $_GET["ayatakhir"];
    $akhirnamasurat = $_GET["akhirnamasurat"];
    $akhirnamasuratlink = $_GET["akhirnamasurat"];
    $akhirnamasurat = str_replace("petik", "'", $akhirnamasurat);
    $sampai = "- $akhirnamasurat $surahakhir : $ayatakhir";
}
if ($kanan > 604 || $kanan < 1) {
    $kanan = 1;
}
$queryview = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1") or die(mysqli_error($koneksi));
$pengaturan = mysqli_fetch_array($queryview);
$qori = $pengaturan['qori'];
?>
<!DOCTYPE html>
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

        <link rel="shortcut icon" href="img/favicon.ico">
        <script src="dist/js/vendor/jquery.min.js"></script>

        <style type="text/css">
            .gambar1{
                max-width: 100%;
                max-height: 100%;
                position: static;
                width: 150%; 
            }
            .gambar2{
                max-width: 100%;
                max-height: 100%;
                position: static;
            }
            .gambar3{
                height: 100px;
                position: fixed;
                z-index: 2;
                top: 100%;
                margin-top: -100px;
            }


            .next{
                height: 30px;
                position: fixed;
                z-index: 2;
                left: 1px;
                top: 50%;
            }
            .back{
                height: 30px;
                position: fixed;
                z-index: 2;
                right: 1px;
                top: 50%;
            }
            .untukbutton{
                position: fixed;
                padding-top: 5px;
                padding-left: 5px;
            }
            .untuksoal{
                position: fixed;
                padding-top: 5px;
                left: 50%;
                margin-left: -200px;
            }
            .soale{
                position: fixed;
                bottom: 10px;
                padding-left: 5px;
                font-size: 20px;
            }
            audio { 
                display:none;
            }
        </style>
    </head>

    <body>

        <style>
            .container{
                padding-top: 20px;
                position: fixed;

            }
        </style>


        <!-- Collect the nav links, forms, and other content for toggling history.go(-1); -->
        <?php
        if (isset($_GET["namasurat"])) {
            $nmsurat = $_GET["namasurat"];
            $nmsurat = str_replace("petik", "'", $nmsurat);
            if (isset($sampai)) {
                echo "<div class='untuksoal'>
                    <button class='btn btn-block btn-lg btn-danger' style='width: 400px' onclick='#'>Soal: <b>$nmsurat $surah : $ayat $sampai</b></button>
                </div>";
            } else {
                echo "<div class='untuksoal'>
                    <button class='btn btn-block btn-lg btn-danger' style='width: 400px' onclick='#'>Soal: <b>$nmsurat $surah : $ayat</b></button>
                </div>";
            }
        }
        ?>

        <div class="untukbutton">
            <button class="btn tn-block btn-lg btn-primary fui-arrow-left" onclick="window.close();" style="width: 120px"> Kembali</button>
            <br>
            <button id="mr" class="btn tn-block btn-lg btn-primary fui-play " style="margin-top: 7px; width: 120px" onclick="playAt()" > Play</button> <br>
            <button id="perbesar" class="btn tn-block btn-lg btn-primary fui-eye "  style="margin-top: 7px; width: 120px" onclick="zoom()"> Perbesar</button><br>
            <button class="btn tn-block btn-lg btn-primary fui-time "  style="margin-top: 7px; width: 120px" onclick="alarm()"> Alarm</button>
            <audio id="audio" >
                <source src="audio/<?php echo $qori; ?>/<?php echo sprintf("%03d", $surah) . sprintf("%03d", $ayat) ?>.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <script>
            function playAt() {
                if (k % 2 == 0) {
                    var audio = document.getElementById('audio');
                    audio.play();
                    $("#mr").text(' Stop');
                } else {
                    var audio = document.getElementById('audio');
                    audio.currentTime = 0;
                    audio.pause();
                    $("#mr").text(' Play');
                }
                k++;
            }
            function stopAudio() {
                var audio = document.getElementById('audio');
                audio.currentTime = 0;
                audio.pause();
            }

            function zoom() {
                if (i % 2 == 0) {
                    $("#besar").show();
                    $("#kecil").hide();
                    $("#perbesar").text(' Perkecil');
                } else {
                    $("#kecil").show();
                    $("#besar").hide();
                    $("#perbesar").text(' Perbesar');
                }
                i++;
            }
            var i = 0;
            var j = 0;
            var k = 0;
            function alarm() {
                console.log("j:" + i);
                if (j % 2 == 0) {
                    $("#alarm").show();
                } else {
                    $("#alarm").hide();
                }
                j++;
            }
        </script>   
        <script>
            $(document).ready(function () {
                $("#mushaf").click(function () {

                });
                var awalnya = <?php Print($awal); ?>;
                if (awalnya === 0) {
                    $(function () {
                        $("#besar").hide(0);
                    });
                }
            });
        </script>
        <div  id="besar"     <?php
        if ($awal === 1) {
            echo 'style="display:none;"';
        }
        ?> >
            <img id="besar" src="Mushaf/<?php echo $kanan ?>.png" class="gambar1"> 
        </div>
        <div id="kecil" >

            <img  src="Mushaf/<?php echo $kanan ?>.png" class="gambar2 nav center-block">
        </div>

        <div class="container" id="mushaf">
            <div class="row">
                <?php
                if ($kanan == 603) {
                    if($sampai){
                        echo "<a href='mushaf.php?kanan=1&surah=$surah&ayat=$ayat&namasurat=$namasuratlink&surahakhir=$surahakhir&ayatakhir=$ayatakhir&akhirnamasurat=$akhirnamasuratlink'><img src='gambar/next.png' class='next'></a>";
                    } else if(isset($_GET["namasurat"])){
                        echo "<a href='mushaf.php?kanan=1&surah=$surah&ayat=$ayat&namasurat=$namasuratlink'><img src='gambar/next.png' class='next'></a>";
                    } else {
                        echo "<a href='mushaf.php?kanan=1'><img src='gambar/next.png' class='next'></a>";
                    }
                } else {
                    if($sampai){
                        echo "<a href='mushaf.php?kanan=" . ($kanan + 1) . "&surah=$surah&ayat=$ayat&namasurat=$namasuratlink&surahakhir=$surahakhir&ayatakhir=$ayatakhir&akhirnamasurat=$akhirnamasuratlink'><img src='gambar/next.png' class='next'></a>";
                    } else if(isset($_GET["namasurat"])){
                        echo "<a href='mushaf.php?kanan=" . ($kanan + 1) . "&surah=$surah&ayat=$ayat&namasurat=$namasuratlink'><img src='gambar/next.png' class='next'></a>";
                    } else {
                        echo "<a href='mushaf.php?kanan=" . ($kanan + 1) . "'><img src='gambar/next.png' class='next'></a>";
                    }
                }
                ?>


                <?php
                if ($kanan == 1) {
                    if($sampai){
                        echo "<a href='mushaf.php?kanan=603&surah=$surah&ayat=$ayat&namasurat=$namasuratlink&surahakhir=$surahakhir&ayatakhir=$ayatakhir&akhirnamasurat=$akhirnamasuratlink'><img src='gambar/back.png' class='back'></a>";
                    } else if(isset($_GET["namasurat"])){
                        echo "<a href='mushaf.php?kanan=603&surah=$surah&ayat=$ayat&namasurat=$namasuratlink'><img src='gambar/back.png' class='back'></a>";
                    } else {
                        echo "<a href='mushaf.php?kanan=603'><img src='gambar/back.png' class='back'></a>";
                    }
                } else {
                    if($sampai){
                        echo "<a href='mushaf.php?kanan=" . ($kanan - 1) . "&surah=$surah&ayat=$ayat&namasurat=$namasuratlink&surahakhir=$surahakhir&ayatakhir=$ayatakhir&akhirnamasurat=$akhirnamasuratlink'><img src='gambar/back.png' class='back'></a>";
                    } else if(isset($_GET["namasurat"])){
                        echo "<a href='mushaf.php?kanan=" . ($kanan - 1) . "&surah=$surah&ayat=$ayat&namasurat=$namasuratlink'><img src='gambar/back.png' class='back'></a>";
                    } else {
                        echo "<a href='mushaf.php?kanan=" . ($kanan - 1) . "'><img src='gambar/back.png' class='back'></a>";
                    }
                }
                ?>
            </div>
        </div>

        <div id="alarm" hidden="" >
            <img  src="gambar/alarm.gif" class="gambar3 nav">
        </div>

        <script src="dist/js/vendor/jquery.min.js"></script>
        <script src="dist/js/vendor/video.js"></script>
        <script src="dist/js/flat-ui.min.js"></script>
        <script src="docs/assets/js/application.js"></script>

        <script>
            videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
        </script>
    </body>
</html>
