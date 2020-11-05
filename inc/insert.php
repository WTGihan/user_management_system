<?php 


require 'connection.php';

// wtgihan@gmail.com = 1234
// anura@gmail.com = 1111
// chintha@gmail.com = 2222
// thanuj@gmail.com = 3333
// ravindu@gmail.com = 4444
// dilshani@gmail.com = 5555
// nimni@gmail.com = 6666
$first_name = "Nimni";
$last_name = "Nirmani";
$email = "nimni@gmail.com";
$password = 6666;



$hashed_password = sha1($password);

$query = "INSERT INTO users ( 
         first_name, last_name, email, password, is_deleted)
         VALUES (
         '{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0
         )";

$result = mysqli_query($connection, $query);


