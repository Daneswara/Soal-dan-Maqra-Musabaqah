<?php

session_start();
require 'koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $sql_check = "SELECT * FROM user WHERE username=? AND password=? LIMIT 1";

    $check_log = $dbconnect->prepare($sql_check);
    $check_log->bind_param('ss', $username, $password);

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $check_log->execute();

    $check_log->store_result();

    if ($check_log->num_rows == 1) {
        $check_log->bind_result($username);

        while ($check_log->fetch()) {
            $_SESSION['user_login'] = $username;
        }

        $check_log->close();

        header('location: index.php#popup3');
        exit();
    } else {
        header('location: login.php?note=1');
        exit();
    }
} else {
    header('location: login.php?note=1');
    exit();
}