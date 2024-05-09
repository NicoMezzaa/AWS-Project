<?php
$hostname="db";
$username="nicolo";
$password="mezza";
$database="site";

$conn=new mysqli($hostname,$username,$password,$database);

if ($conn->connect_error) {
  die("Processo fallito: " . $conn->connect_error);
} else{
  //echo "gg";
}
?>