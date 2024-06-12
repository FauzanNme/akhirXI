<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
if (!isset($_SESSION['login'])) {
    header('location:login.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Menampilkan semua data dari table product berdasarkan id secara Descending
// $product = query("SELECT * FROM product ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style type="text/css">
        html {
            height: 100%;
            overflow: hidden;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        * {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        h1 {
            text-transform: uppercase;
            color: black;
        }

        table {
            border: 1px solid #ddeeee;
            border-collapse: collapse;
            border-spacing: 0;
            width: 70%;
            margin: 10px auto 10px auto;
        }

        table thead th {
            background-color: #ddefef;
            border: 1px solid #ddeeee;
            color: #336b6b;
            padding: 10px;
            text-align: center;
        }

        table tbody td {
            border: 1px solid #ddeeee;
            color: #333;
            padding: 10px;
            text-align: left;
        }

        a {
            text-decoration: none;
            color: black;
            font-size: 12px;
            padding: 10px;
        }

        .icon-link {
            display: inline-block;
            transition: background-color 0.3s;
        }

        .icon-link:hover {
            background-color: darkgrey;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 5px;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">M One</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_product.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <center><a href="add_product.php" style="background-color: #1B262C; color: white; border-radius: 20px; padding: 10px 20px; text-decoration: none;">+ &nbsp; Tambah Product</a></center>

    <br>
    <table id="example" class="table table-striped table table-striped table-responsive table-hover text-center"
        style="width:80%">
        <thead class="table-dark">
            <th>No.</th>
            <th>Item</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Gambar</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php
            $query = "SELECT items.*, images.image_url FROM items 
            LEFT JOIN images ON items.item_id = images.item_id 
            ORDER BY items.item_id ASC";
            $result = mysqli_query($conn, $query);

            if (!$result) {

                die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
            }
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {

                ?>
                <tr>
                    <td>
                        <?php echo $no,"."; ?>
                    </td>
                    <td>
                        <?php echo $row['name']; ?>
                    </td>
                    <td>
                        <?php echo substr($row['description'], 0, 30); ?>...
                    </td>
                    <td>
                        <?php echo number_format($row['quantity'], 0, ',', '.'); ?>
                    </td>
                    <td>Rp
                        <?php echo number_format($row['price'], 0, ',', '.'); ?>
                    </td>
                    <td><img src="gambar/<?php echo $row['image_url']; ?>" style="width:100px;"></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['item_id']; ?>" class="icon-link"
                            style="background-color: #1B262C; color: white; border-radius: 10px; padding: 10px 13px">
                            <i class="bi bi-pencil-square" style="color: white;"></i>
                        </a>
                        <a href="delete_proccess.php?item_id=<?php echo $row['item_id']; ?>"
                            onclick="return confirm('Anda yakin ingin hapus data ini?')" class="icon-link"
                            style="background-color: #1B262C; color: white; border-radius: 10px; padding: 10px 13px;">
                            <i class="bi bi-trash" style="color: white;"></i>
                        </a>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </tbody>
    </table>


    <footer>
        <div class="wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row bg-dark text-white">
                        <div class="col-md-6 my-2" id="about">
                            <h4 class="fw-bold text-uppercase">About</h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae dolore sed porro
                                modi mollitia quaerat? Nam, error fugit sed, maiores illum architecto, officiis
                                voluptate nesciunt voluptatibus aut reprehenderit perspiciatis doloremque!</p>
                        </div>
                        <div class="col-md-6 my-2 text-center link">
                            <h4 class="fw-bold text-uppercase">Account Links</h4>
                            <a href="#" target="_blank"><i
                                    class="bi bi-facebook fs-3"></i></a>
                            <a href="#" target="_blank"><i
                                    class="bi bi-github fs-3"></i></a>
                            <a href="#" target="_blank"><i
                                    class="bi bi-instagram fs-3"></i></a>
                            <a href="#" target="_blank"><i
                                    class="bi bi-twitter fs-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <p>Created By Apip</u></p>
    </footer>
    </div>

    <!-- bootstarp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>




















<?php include('db.php'); 
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM items LEFT JOIN images ON items.item_id = images.item_id WHERE items.item_id = '$id'";
    $result = mysqli_query($conn, $query);
    if(!$result) {
    die("Query Error: ".mysqli_errno($conn)." - ".mysqli_error($conn));
    }
    $data = mysqli_fetch_assoc($result);
    if(!count($data)) {
    echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
    exit();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD GILACODING</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        .container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .base {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .base div {
            margin-bottom: 15px;
            width: 100%;
        }

        .base label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
        }

        .base input[type="text"],
        .base input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .base button {
            width: 100%;
            padding: 12px;
            background-color: #3282B8;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .base button:hover {
            background-color: #0F4C75;
        }
    </style>

</head>

<body>
    
    <div class="container">
    <center>
        <h1>Edit <?php echo $data['name']; ?></h1>
    </center>
    <form method="POST" action="edit_proccess.php" method="post" enctype="multipart/form-data">
        <section class="base">
            <div>
                <label>Nama Produk</label>
                <input type="text" name="name" autofocus="" required="" value="<?php echo $data['name']; ?>"/>
                <input type="hidden" name="id" value="<?php echo $data['item_id']; ?>" />
            </div>
            <div>
                <label>description</label>
                <input type="text" name="description" required="" value="<?php echo $data['description']; ?>"/>
            </div>
            <div>
                <label>Harga Beli</label>
                <input type="text" name="quantity" required="" value="<?php echo $data['quantity']; ?>"/>
            </div>
            <div>
                <label>Harga Jual</label>
                <input type="text" name="price" required="" value="<?php echo $data['price']; ?>"/>
            </div>
            <div>
                <label>Gambar Produk</label>
                <td><img src="gambar/<?php echo $data['image_url']; ?>" style="width:100px;"></td>
                <br>
                <input type="file" name="image_url"/>
                <i style="float: left; font-size: 11px;color:red;">Abaikan jika tidak merubah gambar</i>
            </div>
            <div>
                <button type="submit">Simpan Perubahan</button>
            </div>
        </section>
    </form>
    </div>
</body>

</html>