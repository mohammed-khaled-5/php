<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
</head>
<body>
<!DOCTYPE html>
<html>
<head>
	<title>Login and signup</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">
			<div class="signup">
				<form method="post">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input class="input"  type="email" name="Email" placeholder="Email">
					<input  type="password" name="Password" placeholder="Password">
                    <input   type="text" name="Username" placeholder="Username">
                    <input  type="text" name="Address" placeholder="Address">
                    <input   type="text" name="Location" placeholder="Location">
                    <input  type="text" name="Phone" placeholder="Phone">
                    <input type="file" name="Photo"  accept=".jpg, .jpeg, .png">
					<button name="submit">Sign up</button>
				</form>
                <a href="signUpMarket.php" ><button>Go to Sign up as market</button></a>
			</div>
			<div class="login" id="login">
				<form method="post">
					<label for="chk" aria-hidden="true" id="login">Login</label>
					<input type="text" name="Username" placeholder="Username">
					<input type="password" name="Password" placeholder="Password">
					<button name="submit1">Login</button>
				</form>
			</div>
	</div>
</body>
</html>
<?php
$connection=mysqli_connect("localhost","root","12345678","test") ;
if (isset($_POST['submit1'])) {
//login logic
    $Password = $_POST["Password"];
    $Username = $_POST["Username"];
    $res = mysqli_query($connection,"select * from user where Username='$Username' and Password='$Password'");
    $row = $res-> fetch_array();
    $id = $row['id'];
    $numRows = mysqli_num_rows($res);
    if($numRows  == 1){       
        header("Location: index.php?id=$id");
    }
    else{
        echo '<script>alert("username or password is incorrect")</script>';
    }
}
mysqli_close($connection);
?>
<?php
//sign up logic
$connection=mysqli_connect("localhost","root","12345678","test") ;
if (isset($_POST['submit'])) { 
    $Email = $_POST["Email"];
    $Password = $_POST["Password"];
    $Username = $_POST["Username"];
    $Address = $_POST["Address"];
    $Location = $_POST["Location"];
    $Phone = $_POST["Phone"];
    $Photo = $_POST["Photo"];
    $res=mysqli_query($connection,"select * from user where (Username='$Username' or Email='$Email')");
      if (mysqli_num_rows($res) > 0) {        
            echo '<script>alert("email or username already exists")</script>';
		}
        else{
            $query="INSERT INTO `user` (`id`, `Email`, `Password`, `Username`, `Address`, `Location`, `Phone`, `Photo`, `market`) VALUES (NULL, '$Email', '$Password', '$Username', '$Address', '$Location', '$Phone','$Photo','0')";
            $result =mysqli_query($connection,$query);
            echo '<script>alert("Signed up successfully")</script>';
        } 
}
mysqli_close($connection);
?>