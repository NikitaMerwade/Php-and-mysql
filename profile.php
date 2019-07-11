<?php
include('server.php');
?>
<?php
// You must login before you execute this file  
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Page</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

	<div class="header" >
	<p>USERNAME :<?php $uname = $_SESSION['username']; echo "$uname"; ?> </p>
	<p>EMAIL :
		<?php 
		$rest= mysqli_query($db,"SELECT email FROM `nikitadbt`.`users` WHERE username='$uname'");
		while($eml=mysqli_fetch_array($rest))
		echo $eml['email']; ?> 
	</p>
	</div>
	
	<div class="content">
	<table  width="99%" id="rows">
	<tr><th>DATE</th><th>TIME</th><th>MESSAGE</th></tr>
	<?php
	$res= mysqli_query($db,"SELECT * FROM `nikitadbt`.`diary` WHERE uname='$uname' ");
	while($row=mysqli_fetch_array($res))
	{?>
	
	 <tr>
	 <td> <?php echo $row['date']; ?> </td> 
	 <td> <?php echo $row['time']; ?> </td> 
     <td> <?php echo $row['message']; ?></td>
	 </tr>
	<?php } ?> 
	</table>
	</div>
	
	<div align="center" style="padding:20px">
	<table >
		<tr height="10">
		<td>
		</td>
		<td>
		<a href="index.php?btn=1" class="btn">Add New Message</a>
		</td>
		<td>
		<p><a href="index.php?logout='1'" class="btn">Logout</a> </p>
		</td>
		</tr>
	</table>
	</div>
</body>
</html>