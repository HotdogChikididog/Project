<?php 
$conn = mysqli_connect("localhost:3306","root","","file_management");

if(!$conn){
	die("Connection error: " . mysqli_connect_error());	
}

if(!function_exists('get_metadata'))
{
	$get_metadata = function($slug) use($conn)
	{
		$table = "meta_data";
		
		$statement = $conn->prepare("SELECT * FROM $table WHERE slug = ?");
		$statement->bind_param("s", $slug);
		$statement->execute();
		$result = $statement->get_result();
		$data = $result->fetch_assoc();
		return empty($data) ? 0 : 1;
	};
}
?>