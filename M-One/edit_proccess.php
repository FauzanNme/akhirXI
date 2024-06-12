<?php
include 'db.php';

$item_id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$image_url = $_FILES['image_url']['name'];

if ($image_url != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $x = explode('.', $image_url);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['image_url']['tmp_name'];
    $angka_acak = rand(1, 999);
    $nama_gambar_baru = $angka_acak . '-' . $image_url;

    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if (move_uploaded_file($file_tmp, "gambar/" . $nama_gambar_baru)) {
            $query = "UPDATE items SET name = '$name', description = '$description', quantity = '$quantity', price = '$price' WHERE item_id = '$item_id'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
            } else {
                $query_image = "UPDATE images SET image_url = '$nama_gambar_baru' WHERE item_id = '$item_id'";
                $result_image = mysqli_query($conn, $query_image);

                if (!$result_image) {
                    die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
                } else {
                    echo "<script>alert('Data berhasil diperbarui!');window.location='index.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar!');window.location='edit.php?id=$item_id';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar hanya bisa jpg dan png!');window.location='edit.php?id=$item_id';</script>";
    }
} else {
    $query = "UPDATE items SET name = '$name', description = '$description', quantity = '$quantity', price = '$price' WHERE item_id = '$item_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
    } else {
        echo "<script>alert('Data berhasil diperbarui!');window.location='index.php';</script>";
    }
}
?>

