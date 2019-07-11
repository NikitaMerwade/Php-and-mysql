<?php
session_start();
//initializing variables
$username = "";
$email    = "";
$errors = array(); 
$uname=$username;

// connect to the database
$db = mysqli_connect('localhost', 'root', '');
//Create new database - Once the file loaded on browser nikitadbt database get crated
$dtbs = "CREATE DATABASE IF NOT EXISTS nikitadbt";
mysqli_query($db, $dtbs);
//create tables into the database nikitadbt and run the query
$sqla = "CREATE TABLE IF NOT EXISTS `nikitadbt`.`users`(
      `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `username` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `password` varchar(100) NOT NULL)";
mysqli_query($db, $sqla);
// Create another table and run the query
$sqlb = "CREATE TABLE IF NOT EXISTS`nikitadbt`.`diary` (
`id` INT(254) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`date` DATE NOT NULL, 
`message` VARCHAR(500) NOT NULL, 
`time` TIME NOT NULL, 
`uname` VARCHAR(500) NOT NULL)";

mysqli_query($db, $sqlb);

//Register users
if (isset($_POST['reg_user'])) {
  //receive all the input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: check for errors by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }
  //check the database to make sure a user does not already exist with the same username and email
  $user_check_query = "SELECT * FROM `nikitadbt`.`users` WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }
	if ($user['email'] === $email) { // if email exists
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO `nikitadbt`.`users` (`username`, `email`, `password`) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }
  
  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM `nikitadbt`.`users` WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
 
}
//Recieve input from diary and insert into database nikitadbt table diary
if(isset($_POST['addinfo'])){
	$uname = $_SESSION['username']; 
	$db = mysqli_connect('localhost', 'root', '', 'nikitadbt');
	$date1 = mysqli_real_escape_string($db, $_POST['today']);
	$content = mysqli_real_escape_string($db, $_POST['message']);
	$time1=date('Y-m-d H:i:s');
	
	if ( empty($date1)){ array_push($errors, "Select Date"); }
	if( empty($content)){ array_push($errors, "Write Your Message"); }
	if(count($errors) == 0)
	{
		$sql= "INSERT INTO `nikitadbt`.`diary`(`date`, `message`, `time`, `uname`) VALUES ('$date1', '$content', '$time1', '$uname')";
		$res= mysqli_query($db, $sql);
		if ($res==1) { $_SESSION['success'] = "Data inserted successfully"; }
	}
	
}
?>