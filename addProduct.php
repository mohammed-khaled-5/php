<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

</head>

<body>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Add Product</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="signup">
                <form method="post">
                    <label for="chk" aria-hidden="true">Add product</label>
                    <input class="input" type="text" name="Name" placeholder="Name">
                    <input class="input" type="text" name="Brand" placeholder="Brand">
                    <input class="input" type="number" name="Price" placeholder="Price">
                    <input class="input" type="text" name="Brief_description" placeholder="Brief_description">
                    <input class="input" type="text" name="Full_description" placeholder="Full_description">
                    <input class="input" type="number" name="num_of_items_available" placeholder="num_of_items_available">
                    <input type="file" name="Product_image" accept=".jpg, .jpeg, .png">
                    <button name="Addproduct">Add product</button>
                </form>
                <?php
                $search3 = $_GET['marketid'];
                $connection = mysqli_connect("localhost", "root", "12345678");
                $database = mysqli_select_db($connection, "test");
                $sql = "SELECT * from market where id=$search3 ";
                $result3 = $connection->query($sql);
                $row2 = $result3->fetch_assoc();
                $sql = "SELECT * from user where id=$row2[userid]";
                $result3 = $connection->query($sql);
                $row2 = $result3->fetch_assoc();
                $userid = $row2["id"];
                ?>
                <a href='profile.php?id=<?php echo "$userid" ?>'><button>Profile</button></a>
            </div>

        </div>
    </body>

    </html>
    <?php
    $search = $_GET['marketid'];
    $connection = mysqli_connect("localhost", "root", "12345678");
    $database = mysqli_select_db($connection, "test");

    $marketId = $_GET["marketid"];
    if (isset($_POST['Addproduct'])) {
        $Name = $_POST["Name"];
        $Brand = $_POST["Brand"];
        $Price = $_POST["Price"];
        $Brief_description = $_POST["Brief_description"];
        $Full_description = $_POST["Full_description"];
        $num_of_items_available = $_POST["num_of_items_available"];
        $Product_image = $_POST["Product_image"];
        $query = "INSERT INTO `product` (`id`, `Name`, `Brand`, `Price`, `Brief_description`, `Full_description`, `num_of_items_available`, `Product_image`,`marketId`) VALUES (NULL, '$Name', '$Brand', '$Price', '$Brief_description', '$Full_description', '$num_of_items_available','$Product_image','$search')";
        $result = mysqli_query($connection, $query);
        echo '<script>alert("Product added successfully")</script>' ;
    }

    mysqli_close($connection);


    ?>