<?php 
$conn = mysqli_connect("localhost:3306","root","","file_management");

if(!$conn){
	die("Connection error: " . mysqli_connect_error());	
}
?>