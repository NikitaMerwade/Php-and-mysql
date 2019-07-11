<?php include('server.php') ?>
<?php 
//you must log in to execute this file
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
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="header">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      <h4>
      <?php 
      echo $_SESSION['success']; 
      unset($_SESSION['success']);
      ?>
      </h4>
      </div>
  	<?php endif ?>
	<!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php $uname = $_SESSION['username']; echo $uname; ?></strong></p>
    <?php endif ?>
	<h3>Write Your Dairy</h3>
</div>

<form method="post" action="index.php">
<?php include('errors.php'); ?>
	<div class="input-group">
	<lable>Select Date</lable>
	<input type="date" name="today">
	</div>
	
	<div class="input-group">
	<label>Message</label>
	<textarea name="message" cols="45" rows="5" placeholder="Write something!" style="border: 1px solid gray"></textarea>
	</div>

	<div class="input-group">
	<button type="submit" class="btn" name="addinfo">Click To Add</button>
	</div>	
</form>
<div align="center" style="padding:20px">
	<table>
	<tr>
	<td>
	<a href="profile.php?btn=1" class="btn">View Your Profile</a>
	</td>
	<td>
	<p><a href="index.php?logout='1'" class="btn">Logout</a> </p>
	</td>
	</tr>
	</table>
</div>

</body>
</html>