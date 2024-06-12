<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "crudapp";
    $conn = mysqli_connect("$host", "$user", "$pass", "$db");

    if (!$conn) {
        die("Koneksi dengan databases gagal: ".mysqli_connect_error());
    }
?>