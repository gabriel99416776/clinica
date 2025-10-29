<?php
$conn = new mysqli("localhost","root","","clinica");

if ($conn->connect_error){
    echo "Error". $conn->connect_error;
    exit;
}

?>