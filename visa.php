<?php 
$search = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
</head>
<body>
<!DOCTYPE html>
<html>
<head>
	<title>Visa information</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">
			<div class="signup">
				<form method="post" action="profile.php?id=<?php echo "$search";?>">
                    <label for="chk" aria-hidden="true">Visa info</label>
					<input  type="text" name="Visa number" placeholder="Visa number">
                    <input   type="date" name="date" placeholder="date">
                    <input  type="text" name="cvv" placeholder="cvv">
					<button name="submit">confirm</button>
				</form>
			</div>
	</div>
</body>
</html>
