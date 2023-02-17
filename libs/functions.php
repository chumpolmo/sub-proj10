<?php
function connectDB(){
	$servername = "localhost";
	$username = "ajkhaeg";
	$password = "nimda";
	$database = "pineapple_jobs";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
  		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function exeQuery($sql, $conn){
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
  		//while($row = $result->fetch_assoc()) {
    	//	echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
  		//}
	} else {
  		return false;
	}
}

function closeConDB($conn){
	$conn->close();	
}

function getJobStatus($j){
	if($j == 10){
		return "เปิดรับคนทำงาน";
	}else if($j == 20){
		return "ปิดรับคนทำงาน";
	}
}
?>