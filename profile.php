<?php
$search = $_GET['id'];
$connection = mysqli_connect("localhost", "root", "12345678", "test");
$res = mysqli_query($connection, "select * from user where id=$search");
$row = $res->fetch_assoc();
$Email = $row['Email'];
$Password = $row['Password'];
$Username = $row['Username'];
$Address = $row['Address'];
$Location = $row['Location'];
$Phone = $row['Phone'];
$Photo = $row['Photo'];
$market = $row['market'];
$res1 = mysqli_query($connection, "select * from market where userid=$search");
$row1 = $res1->fetch_assoc();
$name = $row1['name'];
$balance = $row1['balance'];
$balance_no = $row1['balance_no'];
$marketid = $row1['id'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="https://kit.fontawesome.com/ee30d094db.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

</head>


<body>
    <header class="header">
        <div><img style="width:60px; height:80px" src="images/<?php echo $row['Photo']; ?>"></div>
        <div class="websiteName">
            <img src="images/logo.png" style="width: 80px;margin-left:35%;padding-top:10px;">
        </div>
        <div>
            <form method="post">
                <ul class="main-nav">
                    <li><input type="submit" name="button1" class="button" value="Favorite products" /></li>
                    <li><input type="submit" name="button2" class="button" value="Liked markets" /></li>
                    <li><input type="submit" name="button3" class="button" value="Purchased products" /></li>
                    <li><input type="submit" name="button4" class="button" value="Cart" /></li>
                    <li><input type="submit" name="button5" class="button" value="In process products" /></li>
                    <li>
                        <div class="navbar"><a href="index.php?id=<?php echo $search ?>"><span>Home</span></a></div>
                    </li>
                    <li>
                        <div class="navbar"><a href="index.php"><span>LogOut</span></a></div>
                    </li>

                </ul>
            </form>
        </div>
    </header>
    <div class="flex2">
        <div class="labels">

            <form method="post">
                <label aria-hidden="true"><span>Email: </span> <?php echo "$Email" ?></label>
                <label aria-hidden="true"><span>Username: </span><?php echo "$Username" ?></label>
                <label aria-hidden="true"><span>Address: </span><?php echo "$Address" ?></label>
                <label aria-hidden="true"><span>Location: </span><?php echo "$Location" ?></label>
                <label aria-hidden="true"><span>Phone: </span><?php echo "$Phone" ?></label>
                <img name='Photo' accept='.jpg, .jpeg, .png' src="images/<?php echo "$Photo" ?>">
                <?php
                if ($market == 1) {

                    echo "<label ><span>market name: </span>$name </label>";
                    echo "<label ><span>balance: </span> $balance</label>";
                    echo "<label ><span>balance_no: </span>$balance_no </label>";
                    echo "<a href='addProduct.php?marketid=$marketid'>ADD PRODUCT</a>";
                }
                ?>
            </form>
            <button onclick="Openform();" style="padding: 8px 5px;width:200px ;height:50px ">edit your profile info</button>
        </div>
        <div class="main" id="form1" style="display: none">
            <div class="signupForMarket">
                <form method="post">
                    <label for="chk" aria-hidden="true">Edit your Profile</label>
                    <input class="input" type="email" name="Email" placeholder="Email" value="<?php echo "$Email" ?>">
                    <input class="input" type="password" name="Password" placeholder="Password" value="<?php echo "$Password" ?>">
                    <input class="input" type="text" name="Username" placeholder="Username" value="<?php echo "$Username" ?>">
                    <input class="input" type="text" name="Address" placeholder="Address" value="<?php echo "$Address" ?>">
                    <input class="input" type="text" name="Location" placeholder="Location" value="<?php echo "$Location" ?>">
                    <input class="input" type="text" name="Phone" placeholder="Phone" value="<?php echo "$Phone" ?>">
                    <input type='file' name='Photo' accept='.jpg, .jpeg, .png' value="images/<?php echo "$Photo" ?>">
                    <?php
                    if ($market == 1) {
                        echo " <input class='input' type='text' name='name' placeholder='Market name'  value= '$name' >";
                        echo "<input class='input' type='number' name='balance' placeholder='balance' value='$balance'>";
                        echo "<input class='input' type='number' name='balance_no' placeholder='balance number' value='$balance_no'>";
                    }
                    ?>
                    <button name="submit5" onclick="reload()">edit</button>
                </form>

            </div>

        </div>
        
    </div>
    <?php
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
    if(isset($_POST['cart'])) {
        addToCart();
    }
    if(isset($_POST['buy'])) {
        buyProduct();
    }
    if(isset($_POST['process'])) {
        processProduct();
    }
    function processProduct(){
        $search = $_GET['id'];
        $search2 = $_POST['gettheid'];
        $conn = mysqli_connect("localhost", "root", "12345678", "test");
        $sql = "DELETE FROM `cart` where userid=$search and productid=$search2  ";
        $result =mysqli_query($conn,$sql);
        $sql1 = "INSERT INTO `processproducts`  (`id`, `userid`, `productid`) VALUES (NULL, '$search', '$search2') ";
        $result1 =mysqli_query($conn,$sql1);
        $sql2 = "SELECT * FROM `product` where  id=$search2";
                $result2 =mysqli_query($conn,$sql2);
                $row = $result2->fetch_assoc();
                $numberOfproduct = $row["num_of_items_available"];
                $numberOfproduct = $numberOfproduct - 1;
                $query = "UPDATE `product` SET `num_of_items_available` = '$numberOfproduct' WHERE id=$search2 ";
                $result3 =mysqli_query($conn,$query);
    }
    function buyProduct(){
        $search = $_GET['id'];
        $search2 = $_POST['gettheid'];
        $conn = mysqli_connect("localhost", "root", "12345678", "test");
                
                $sql = "DELETE FROM `cart` where userid=$search and productid=$search2  ";
                $result =mysqli_query($conn,$sql);
                $sql1 = "INSERT INTO `purchasedproducts`  (`id`, `userid`, `productid`) VALUES (NULL, '$search', '$search2') ";
                $result1 =mysqli_query($conn,$sql1);
                $sql2 = "SELECT * FROM `product` where  id=$search2";
                $result2 =mysqli_query($conn,$sql2);
                $row = $result2->fetch_assoc();
                $numberOfproduct = $row["num_of_items_available"];
                $numberOfproduct = $numberOfproduct - 1;
                $query = "UPDATE `product` SET `num_of_items_available` = '$numberOfproduct' WHERE id=$search2 ";
                $result3 =mysqli_query($conn,$query);
                header("Location: visa.php?id=$search");
                echo '<script>alert("Bought successfully")</script>' ;
                
                //add the price of the car to the market user balance
                //$query2 = "UPDATE `market` SET `balance` = ' ' WHERE id=$search2 ";

              
    }
        if ($market == 1) {
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from market where userid=$search ";
            $result3 = $conn3->query($sql3);
            $row2 = $result3->fetch_assoc();


            $conn2 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql2 = "SELECT * from product where marketId=$row2[id]";

            $result2 = $conn2->query($sql2);
            echo '<div class="flex">';
            while ($row = $result2->fetch_assoc()) {
                echo '<div class="card" style="width:25%px">';
                echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
                echo    "<div class='container'>";
                echo   "<h4><b> $row[Name] </b></h4>";
                echo     " <p> $row[Brand]</p>";
                echo      "<p> $row[Brief_description]</p>";
                echo      "<p> $row[Price] <p>";
                if ($row["num_of_items_available"] > 0) {
                    echo "<p style='color:green;'>Available <p>";
                } else {
                    echo " <p style='color:red;'>Not Available <p>";
                }

                echo    "</div>";
                echo    "</div>";
            }
            echo "</div>";
        }
        if(isset($_POST['button1'])){
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from favoriteproducts where userid=$search ";
            $result3 = $conn3->query($sql3);
            echo     " <h2 style='color:olive;text-align:center;'>Favorite Products</h2>";
            echo '<div class="flex">';
            while ($row2 = $result3->fetch_assoc()) {
            $sql2 = "SELECT * from product where id=$row2[productid]";
            $result2 = $conn3->query($sql2);
           
            while ($row = $result2->fetch_assoc()) {
                echo '<div class="card" style="width:25%px">';
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

                echo    "</div>";
                echo    "</div>";
            }
        }
            echo "</div>";
        }
        if(isset($_POST['button2'])){
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from likedmarkets where userid=$search ";
            $result3 = $conn3->query($sql3);
            
            while ($row2 = $result3->fetch_assoc()) {
            $sql2 = "SELECT * from market where id=$row2[marketid]";
            $result2 = $conn3->query($sql2);
            $sql5 =  "SELECT * from product where marketId =$row2[marketid]";
            $result5 = mysqli_query($conn3, $sql5);
            while ($row = $result2->fetch_assoc()) {
                echo     " <h2 style='color:white;text-align:center;'><span style='color:olive'>Market name: </span>$row[name]<br>   </h2> </button> </form>";
                echo     " <h2 style='color:olive;text-align:center;'>Market Products:</h2>";
                echo '<div class="flex" style="justify-content: space-around;">';
                while ($row3 = $result5->fetch_assoc()) {
                    echo '<div class="card">';
                    echo "<img style='width:100% ; height:240px;' src='./images/$row3[Product_image]'>";
                    echo    "<div class='container'>";
                    echo   "<h4><b> $row3[Name] </b></h4>";
                    echo     " <p> $row3[Brand]</p>";
                    echo      "<p> $row3[Brief_description]</p>";
                    echo      "<p> $row3[Price] <p>";
                    if ($row3["num_of_items_available"] > 0) {
                        echo "<p style='color:green;'>Available <p>";
                        echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row3[id]'/><button type='submit' class='btn' name='cart' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-cart-plus fa-2xl'></i> Add to cart </button> </form>";
                    } else {
                        echo " <p style='color:red;'>Not Available <p>";
                    }
                    
                    echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row3[id]'/><button type='submit' class='btn' name='favorite' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-star fa-2xl'></i> Add to favorite </button> </form>";
                    echo    "</div>";
                    echo    "</div>";
                }
                echo "</div>";
            }
        }
            
        }
        if(isset($_POST['button3'])){
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from purchasedproducts where userid=$search ";
            $result3 = $conn3->query($sql3);
            echo     " <h2 style='color:olive;text-align:center;'>Purchased Products</h2>";
            echo '<div class="flex">';
            while ($row2 = $result3->fetch_assoc()) {
            $sql2 = "SELECT * from product where id=$row2[productid]";
            $result2 = $conn3->query($sql2);
            
            while ($row = $result2->fetch_assoc()) {
                echo '<div class="card" style="width:25%px">';
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

                echo    "</div>";
                echo    "</div>";
            }
        }
            echo "</div>";
        }
        if(isset($_POST['button4'])){
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from cart where userid=$search ";
            $result3 = $conn3->query($sql3);
            echo     " <h2 style='color:olive;text-align:center;'>Cart Products</h2>";
            echo '<div class="flex">';
            while ($row2 = $result3->fetch_assoc()) {
            $sql2 = "SELECT * from product where id=$row2[productid]";
            $result2 = $conn3->query($sql2);
            
            while ($row = $result2->fetch_assoc()) {
                echo '<div class="card" style="width:25%px">';
                echo "<img style='width:100% ; height:240px;' src='./images/$row[Product_image]'>";
                echo    "<div class='container'>";
                echo   "<h4><b> $row[Name] </b></h4>";
                echo     " <p> $row[Brand]</p>";
                echo      "<p> $row[Brief_description]</p>";
                echo      "<p> $row[Price] <p>";
                if ($row["num_of_items_available"] > 0) {
                    echo "<p style='color:green;'>Available <p>";
                    echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='buy' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-bag-shopping fa-2xl'></i> Buy Visa </button> </form>";
                    echo     "<form method='POST'> <input type='hidden' name='gettheid' value='$row[id]'/><button type='submit' class='btn' name='process' style='background-color: transparent; height:40px;border:0px'> <i class='fa-solid fa-bag-shopping fa-2xl'></i> Buy offline </button> </form>";
                } else {
                    echo " <p style='color:red;'>Not Available <p>";
                }

                echo    "</div>";
                echo    "</div>";
            }
        }
            echo "</div>";
        }
        if(isset($_POST['button5'])){
            $conn3 = mysqli_connect("localhost", "root", "12345678", "test");
            $sql3 = "SELECT * from processproducts where userid=$search ";
            $result3 = $conn3->query($sql3);
            echo     " <h2 style='color:olive;text-align:center;'>In process Products</h2>";
            echo '<div class="flex">';
            while ($row2 = $result3->fetch_assoc()) {
            $sql2 = "SELECT * from product where id=$row2[productid]";
            $result2 = $conn3->query($sql2);
            
            while ($row = $result2->fetch_assoc()) {
                echo '<div class="card" style="width:25%px">';
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

                echo    "</div>";
                echo    "</div>";
            }
        }
            echo "</div>";
        }
        ?>
</body>
<script>
    function Openform() {
        document.getElementById('form1').style.display = 'block';
    }
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);

    }

    function reload() {
        setTimeout("window.location.reload(true);", 3000);
    }
</script>

</html>

<?php

if (isset($_POST['submit5'])) {
    $Email1 = $_POST["Email"];
    $Password1 = $_POST["Password"];
    $Username1 = $_POST["Username"];
    $Address1 = $_POST["Address"];
    $Location1 = $_POST["Location"];
    $Phone1 = $_POST["Phone"];
    $name1 = $_POST["name"];
    $balance1 = $_POST["balance"];
    $balance_no1 = $_POST["balance_no"];
    $Photo1 = $_POST["Photo"];
    if (empty($Photo1)) {
        $Photo1 = $Photo;
    }
    $query = "UPDATE user SET Email='$Email1' , Password='$Password1', Username='$Username1', Address='$Address1', Location='$Location1', Phone='$Phone1', Photo='$Photo1' WHERE id=$search ";
    $result = mysqli_query($connection, $query);

    if ($market == 1) {
        $query1 = "UPDATE market SET name='$name1', balance='$balance1', balance_no='$balance_no1'  WHERE id=$marketid ";
        $result1 = mysqli_query($connection, $query1);
    }
}
mysqli_close($connection);
?>