<?php
include("db.php");

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
            $query = "INSERT INTO items (name, description, quantity, price) VALUES ('$name', '$description', '$quantity', '$price')";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query Error: " . mysqli_errno($conn) . " " . mysqli_error($conn));
            } 
            else {
                // get insert itemid
                $item_id = mysqli_insert_id($conn);

                $query_image = "INSERT INTO images (item_id, image_url) VALUES ('$item_id', '$nama_gambar_baru')";
                $result_image = mysqli_query($conn, $query_image);

                if(!$result_image) {
                    die("Query Error: " . mysqli_errno($conn) . " " . mysqli_error($conn));
                }else {
                    echo "<script>alert('Data berhasil ditambahkan!');window.location='index.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar!');window.location='add_product.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar hanya bisa jpg dan png!');window.location='add_product.php';</script>";
    }
} else {
    $query = "INSERT INTO items (name, description, quantity, price) VALUES ('$name', '$description', '$quantity', '$price')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_errno($conn) . " " . mysqli_error($conn));
    } else {
        echo "<script>alert('Data berhasil ditambahkan!');window.location='index.php';</script>";
    }
}
?>
