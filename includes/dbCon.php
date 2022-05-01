<?php 
$servername = "localhost";
$username = "root";
$password = "Shivam1547";
$conn= new mysqli($servername,$username,$password,'fms_db')or die("Could not connect to mysql".mysqli_error($conn));