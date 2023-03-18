<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARgo</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/all.min.css">
    <script src="https://kit.fontawesome.com/ee30d094db.js" crossorigin="anonymous"></script>
</head>
<body class="body">
    <?php
    $search = $_GET['id'];
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    $sql = "select * from user where id like '%$search%' ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    $valueOfImage = "defaultImage.png";
    $valueOfButton = "login/signUP";
    $valueOgPage = "login.php";
    ?>
    <header class="header">
        <?php
        if ($search) {
            $valueOfImage=$row['Photo'];
            $valueOfButton = "profile";
            $valueOgPage = "profile.php?id=$row[id]";
            
        ?>    
            <div><img style="width:60px; height:80px" src="images/<?php echo $valueOfImage; ?>"></div>
            <div class="websiteName">
                <img src="images/logo.png" style="width: 20%;margin-left:35%;padding-top:10px;">
            </div>
            <div>
                <form method="post">
                    <ul class="main-nav">
                        <li><input type="submit" name="button1" class="button" value="Products" /></li>
                        <li><input type="submit" name="button2" class="button" value="Brands" /></li>
                        <li><input type="submit" name="button3" class="button" value="Markets" /></li>
                        <li class="search"><input type="text" name="search" placeholder="type to search..."></li>
                        <li><input type="submit" name="button4" class="button" value="Search" /></li>
                         
                        <li>
                            <div class="navbar"><a href="<?php echo $valueOgPage; ?>"><span><?php echo $valueOfButton; ?></span></a></div>
                        </li>
                        <li>
                        <div class="navbar"><a href="index.php"><span>LogOut</span></a></div>
                    </li>
                    <?php
                } else {
                    ?>
                        <div><img style="width:60px ; height:80px" src="images/<?php echo $valueOfImage; ?>"></div>
                        <div class="websiteName">
                            <img src="images/logo.png" style="width: 20%;margin-left:35%;padding-top:10px;">
                        </div>
                        <div>
                            <form method="post">
                                <ul class="main-nav">
                                    <li><input type="submit" name="button1" class="button" value="Products" /></li>
                                    <li><input type="submit" name="button2" class="button" value="Brands" /></li>
                                    <li><input type="submit" name="button3" class="button" value="Markets" /></li>
                                    <li class="search"><input type="text" name="search" placeholder="type to search..."></li>
                                    <li><input type="submit" name="button4" class="button" value="Search" /></li>
                                    <li>
                                        <div class="navbar"><a href="<?php echo $valueOgPage; ?>"><span><?php echo $valueOfButton; ?></span></a></div>
                                    </li>
                                <?php
                            }
                                ?>

                                </ul>
                            </form>
                        </div>
    </header>
</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>
<?php
if ( isset($_POST['button1'])) {
    button1();
} else if ( isset($_POST['button2'])) {
    button2();
} else if ( isset($_POST['button3'])) {
    button3();
} else if (isset($_POST['button4'])) {
    button4();
}
else {
    button1();
}
if(isset($_POST['cart'])) {
    addToCart();
}
if(isset($_POST['like'])) {
    addTolike();
}
if(isset($_POST['favorite'])) {
    addToFavorite();
}
function button1()
{
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    $sql = "select * from product ";

    $result = $conn->query($sql);
    echo '<div class="flex">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
        echo    "<div class='container'>";
        echo   "<h4><b> $row[Name] </b></h4>";
        echo     " <p> $row[Brand]</p>";
        echo      "<p> $row[Brief_description]</p>";
        echo      "<p> $row[Price] <p>";
        if ($row["num_of_items_available"] > 0) {
            echo "<p style='color:green;'>Available <p>";
            echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='cart' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-cart-plus fa-2xl'></i> Add to cart </button> </form>";
        } else {
            echo " <p style='color:red;'>Not Available <p>";    
        }
        
       
        echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='favorite' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-star fa-2xl'></i> Add to favorite </button> </form>";
        echo    "</div>";
        echo    "</div>";
    }
    echo "</div>";
    
}

function addToCart(){
    $search = $_GET['id'];
    $search2 = $_POST['gettheid'];
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    if(empty($search)){
        echo '<script>alert("you need to log in first")</script>' ;
    }
    else {
        $sql2= "SELECT * FROM `cart`  WHERE userid=$search and productid=$search2 ";
        $result2 =mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result2) > 0){
            echo '<script>alert("already in the cart")</script>' ;
        }else{
            $sql = "INSERT INTO `cart`  (`id`, `userid`, `productid`) VALUES (NULL, '$search', '$search2') ";
            $result =mysqli_query($conn,$sql);
            echo '<script>alert("added to cart successfully")</script>' ;
        }
       
    }
}
function addTolike(){
    $search = $_GET['id'];
    $search2 = $_POST['gettheid'];
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    if(empty($search)){
        echo '<script>alert("you need to log in first")</script>' ;
    }
    else {
        $sql2= "SELECT * FROM `likedmarkets`  WHERE userid=$search and marketid=$search2 ";
        $result2 =mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result2) > 0){
            echo '<script>alert("already liked")</script>' ;
        }
        else{
            $sql = "INSERT INTO `likedmarkets`  (`id`, `userid`, `marketid`) VALUES (NULL, '$search', '$search2') ";
            $result =mysqli_query($conn,$sql);
            echo '<script>alert("liked successfully")</script>' ;
        }
       
    }
}
function addToFavorite(){
    $search = $_GET['id'];
    $search2 = $_POST['gettheid'];
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    if(empty($search)){
        echo '<script>alert("you need to log in first")</script>' ;
    }
    else {
        $sql2= "SELECT * FROM `favoriteproducts`  WHERE userid=$search and productid=$search2 ";
        $result2 =mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result2) > 0){
            echo '<script>alert("already in the favorite")</script>' ;
        }
        else{
            $sql = "INSERT INTO `favoriteproducts`  (`id`, `userid`, `productid`) VALUES (NULL, '$search', '$search2') ";
        $result =mysqli_query($conn,$sql);
        echo '<script>alert("added to favorite successfully")</script>' ;
        }   
        
    }
}
function button2()
{
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    $sql = "select * from product ";
    $result = mysqli_query($conn, $sql);
    $a = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $brand = $row["Brand"];
            if (in_array($row["Brand"], $a)) {
                continue;
            } else {

                $a[] = $row["Brand"];
                $sql2 = "select * from product where Brand='$brand'";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2->num_rows > 0) {
                    echo "<h2 style='color:white;text-align:center;'>$brand</h2>";

                    echo '<div class="flex" style="justify-content: space-around;">';

                    while ($row = $result2->fetch_assoc()) {

                        echo '<div class="card">';
                        echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
                        echo    "<div class='container'>";
                        echo   "<h4><b> $row[Name] </b></h4>";
                        echo     " <p> $row[Brand]</p>";
                        echo      "<p> $row[Brief_description]</p>";
                        echo      "<p> $row[Price] </p>";
                        if ($row["num_of_items_available"] > 0) {
                            echo "<p style='color:green;'>Available </p>";
                            echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='cart' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-cart-plus fa-2xl'></i> Add to cart </button> </form>";
                        } else {
                            echo " <p style='color:red;'>Not Available </p>";
                        }
                       
                        echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='favorite' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-star fa-2xl'></i> Add to favorite </button> </form>";
                        echo    "</div>";
                        echo    "</div>";
                    }
                    echo "</div>";
                }
            }
        }
        $conn->close();
    }
}function button3()
{
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    $sql = "select * from market ";
    $result = mysqli_query($conn, $sql);
    $a = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            if (in_array($row["name"], $a)) {
                continue;
            } else {

                $a[] = $row["name"];
                $sql2 =  "select * from product where marketId =$row[id]";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2->num_rows > 0) {
                    
                    echo     "<form method='POST'> <h2 style='color:white;text-align:center;'>$name<br> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='like' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-heart fa-2xl'></i> Like </h2> </button> </form>";
                    echo '<div class="flex" style="justify-content: space-around;">';

                    while ($row = $result2->fetch_assoc()) {

                        echo '<div class="card">';
                        echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
                        echo    "<div class='container'>";
                        echo   "<h4><b> $row[Name] </b></h4>";
                        echo     " <p> $row[Brand]</p>";
                        echo      "<p> $row[Brief_description]</p>";
                        echo      "<p> $row[Price] <p>";
                        if ($row["num_of_items_available"] > 0) {
                            echo "<p style='color:green;'>Available <p>";
                            echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='cart' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-cart-plus fa-2xl'></i> Add to cart </button> </form>";
                        } else {
                            echo " <p style='color:red;'>Not Available <p>";
                        }
                        
                        echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='favorite' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-star fa-2xl'></i> Add to favorite </button> </form>";
                        echo    "</div>";
                        echo    "</div>";
                    }
                    echo "</div>";
                }
            }
        }
        $conn->close();
    }
}function button4()
{
    $search = $_POST['search'];
    $conn = mysqli_connect("localhost", "root", "12345678", "test");
    $sql = "SELECT * from product where Brand like '%$search%' or Name like '%$search%' or  Price BETWEEN 0 AND '$search' ";
    $result = $conn->query($sql);

    if (isset($_POST['button4'])) {
        if ($result->num_rows > 0) {
            echo '<div class="flex">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
                echo    "<div class='container'>";
                echo   "<h4><b> $row[Name] </b></h4>";
                echo     " <p> $row[Brand]</p>";
                echo      "<p> $row[Brief_description]</p>";
                echo      "<p> $row[Price] <p>";
                if ($row["num_of_items_available"] > 0) {
                    echo "<p style='color:green;'>Available <p>";
                    echo     "<button class='btn' name='cart' style='background-color: transparent; height:40px;border:0px'><i class='fa-solid fa-cart-plus fa-2xl'></i> Add to cart</button>";
                } else {
                    echo " <p style='color:red;'>Not Available <p>";
                }
                
                echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='favorite' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-star fa-2xl'></i> Add to favorite </button> </form>";
                echo    "</div>";
                echo    "</div>";
            }
            echo "</div>";
        } else {
            echo "nothing like that";
        }
    }
    $conn->close();
}
?>