<?php include('db.php'); 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 2.5rem;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            color: #495057;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3282B8;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0F4C75;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">M One</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add_product.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <h1>Edit <?php echo $data['name']; ?></h1>
        <form method="POST" action="edit_proccess.php" enctype="multipart/form-data">
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
                <br>
                <td><img src="gambar/<?php echo $data['image_url']; ?>" style="width:100px;"></td>
                <input type="file" name="image_url"/>
                <i style="float: left; font-size: 11px;color:red;">Abaikan jika tidak merubah gambar</i>
            </div>
            <div>
                <button type="submit">Simpan Perubahan</button>
            </div>
        </section>
        </form>
    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

