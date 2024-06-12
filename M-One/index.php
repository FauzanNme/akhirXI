<?php
include 'db.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Inisialisasi variabel pencarian
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
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
    <style>
        html {
            height: 100%;
            overflow: auto;
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

        .custom-btn {
            background-color: #3282B8;
            color: white;
            border: none;
            border-radius: 10px;
        }

        .custom-btn:hover {
            background-color: #0F4C75;
            /* Bootstrap's gray color */
            color: white;
        }

        .footer-col .social-links a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0 10px 10px 0;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            color: #ffffff;
            transition: all 0.5s ease;
        }

        .footer-col .social-links a:hover {
            color: #24262b;
            background-color: #ffffff;
        }

        .link i {
            color: white;
            transition: color 0.3s;
            margin: 0 10px;
        }

        .link i:hover {
            color: #9e9595;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
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

    <!-- Container -->
    <div class="container">
        <div class="row my-2">
            <div class="col-md">
                <h3 class="text-center fw-bold text-uppercase">Data Product</h3>
                <hr>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md">
                <a href="add_product.php" class="btn btn-dark custom-btn"
                    style="border-radius: 20px; padding: 10px 20px; text-decoration: none;">+ &nbsp; Tambah Product</a>
            </div>

            <div class="col-md">
                <form method="GET" action="" class="d-flex">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                        aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn custom-btn" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md">
                <table id="data" class="table table-striped table-responsive table-hover text-center"
                    style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modifikasi query untuk pencarian
                        $query = "SELECT items.*, images.image_url FROM items 
                                  LEFT JOIN images ON items.item_id = images.item_id 
                                  WHERE items.name LIKE '%$search%' OR items.description LIKE '%$search%' 
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
                                    <?php echo $no, "."; ?>
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
                                    <a href="edit.php?id=<?php echo $row['item_id']; ?>" class="btn btn-warning btn-sm"><i
                                            class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                                    <a href="delete_proccess.php?item_id=<?php echo $row['item_id']; ?>"
                                        onclick="return confirm('Anda yakin ingin hapus data ini?')"
                                        class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>&nbsp;Hapus</a>
                                </td>

                            </tr>
                            <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <footer>
        <div class="wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row bg-dark text-white">
                        <div class="col-md-6 my-2" id="about">
                            <h4 class="fw-bold text-uppercase">About</h4>
                            <p>Kami adalah kelompok yang fokus dalam menciptakan solusi kreatif dan inovatif untuk masalah yang dihadapi sehari-hari. Dengan semangat dan dedikasi, kami berupaya memberikan layanan terbaik kepada pelanggan kami. Tim kami terdiri dari para profesional berpengalaman dan ahli di bidangnya.</p>
                        </div>
                        <div class="col-md-6 my-2 text-center link">
                            <h4 class="fw-bold text-uppercase">Account Links</h4>
                            <a href="https://facebook.com" target="_blank" class="facebook-link">
                                <i class="bi bi-facebook fs-3"></i>
                            </a>
                            <a href="https://github.com" target="_blank">
                                <i class="bi bi-github fs-3"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank">
                                <i class="bi bi-instagram fs-3"></i>
                            </a>
                            <a href="https://x.com" target="_blank">
                                <i class="bi bi-twitter fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </footer>
    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>