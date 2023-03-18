<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

</head>

<body>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Sign Up for Market</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="signupForMarket">
                <form method="post">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input class="input" type="email" name="Email" placeholder="Email">
                    <input class="input" type="password" name="Password" placeholder="Password">
                    <input class="input" type="text" name="Username" placeholder="Username">
                    <input class="input" type="text" name="Address" placeholder="Address">
                    <input class="input" type="text" name="Location" placeholder="Location">
                    <input class="input" type="text" name="Phone" placeholder="Phone">
                    <input class="input" type="text" name="name" placeholder="Market name">
                    <input class="input" type="number" name="balance" placeholder="balance">
                    <input class="input" type="number" name="balance_no" placeholder="balance number">
                    <input type="file" name="Photo" accept=".jpg, .jpeg, .png">
                    <button name="submit5">Sign up</button>
                    
                </form>
                <a href="login.php" ><button>Login</button></a>
            </div>

        </div>
    </body>

    </html>
    
    <?php
    $connection = mysqli_connect("localhost", "root", "12345678", "test");
    if (isset($_POST['submit5'])) {
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];
        $Username = $_POST["Username"];
        $Address = $_POST["Address"];
        $Location = $_POST["Location"];
        $Phone = $_POST["Phone"];
        $name = $_POST["name"];
        $balance = $_POST["balance"];
        $balance_no = $_POST["balance_no"];
        $Photo = $_POST["Photo"];
        $res=mysqli_query($connection,"select * from user where (Username='$Username' or Email='$Email')");
        if (mysqli_num_rows($res) > 0) {        
            echo '<script>alert("email or username already exists")</script>';
		}
        else{
        $query = "INSERT INTO `user` (`id`, `Email`, `Password`, `Username`, `Address`, `Location`, `Phone`, `Photo`, `market`) VALUES (NULL, '$Email', '$Password', '$Username', '$Address', '$Location', '$Phone','$Photo','1')";
        $result = mysqli_query($connection, $query);
        $lastInsertedId = mysqli_insert_id($connection);
        $query1 = "INSERT INTO `market`(`id`,`name`, `userid`, `balance`, `balance_no`) VALUES (NULL,'$name','$lastInsertedId', '$balance', '$balance_no')";
        $result1 = mysqli_query($connection, $query1);
        echo '<script>alert("Signed up successfully")</script>';
        }   
    }
    mysqli_close($connection);
    ?>