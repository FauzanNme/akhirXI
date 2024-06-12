<?php

include('db.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter item_id ada di URL
if (!isset($_GET['item_id']) || empty($_GET['item_id'])) {
    die("Item ID tidak ditemukan.");
}

$item_id = $_GET['item_id'];

// Hapus data terkait di tabel images terlebih dahulu
$query_images = "DELETE FROM images WHERE item_id='$item_id'";
$result_images = mysqli_query($conn, $query_images);

if (!$result_images) {
    die("Query Error (images): " . mysqli_errno($conn) . " - " . mysqli_error($conn));
}

// Setelah menghapus data terkait, hapus data dari tabel items
$query_items = "DELETE FROM items WHERE item_id='$item_id'";
$result_items = mysqli_query($conn, $query_items);

if (!$result_items) {
    die("Query Error (items): " . mysqli_errno($conn) . " - " . mysqli_error($conn));
} else {
    echo "<script>alert('Data berhasil dihapus!');window.location='index.php';</script>";
}

?>