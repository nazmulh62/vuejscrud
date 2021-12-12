<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vuecrud";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_errno){
    die("Database connect errno!");
}

$response = ["error" => false];

$action = "read";

if(isset($_GET["action"])) {
    $action = $_GET["action"];
}

if($action == "read"){
//echo $action;
$users = array();
$result = $conn->query("SELECT * FROM users");
while($row = $result->fetch_assoc()){
    array_push($users, $row);
 }
  $response["users"] = $users;
}elseif($action == "create"){

    $name     = $_POST["name"];
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $result   = $conn->query("INSERT INTO users (name, username, email) VALUES ('$name', '$username', '$email')");

    if($result){
    $response["message"] = "Data Save Success!";
  } else {
    $response["error"] = true;
    $response["message"] = "Data Save Failed!";
  }

} elseif ($action == "update"){
   $id       = $_POST['id']; 
   $name     = $_POST["name"];
   $username = $_POST["username"];
   $email    = $_POST["email"];
   $result = $conn->query("UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email' WHERE id = '$id'");
   if($result) {
     $response["message"] = "Data Updated Successfully!";
   } else  {
     $response['error'] = true;
     $response["message"] = "Data updated failed!";
   }
   //echo $action;

} elseif ($action == "delete"){
  $id = $_POST["id"];
  $result = $conn->query("DELETE FROM `users` WHERE id = '$id'");
  if($result) {
    $response["message"] = "Data Deleted Successfully!";
  } else  {
    $response['error'] = true;
    $response["message"] = "Data Deleted failed!";
  }
  //echo $action;
} else{
  die("Invloid action!");
}


header('content-type: application/json');
echo json_encode($response);

?>